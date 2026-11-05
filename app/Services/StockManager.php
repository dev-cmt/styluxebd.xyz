<?php

namespace App\Services;

use App\Product;
use App\ProductVariant;
use App\WebSettings;

class StockManager
{
    public static function decreaseStockForOrder($orderItems, $usePurchaseTableSetting = null)
    {
        if ($usePurchaseTableSetting === null) {
            $settings = WebSettings::first();
            $usePurchaseTableSetting = $settings ? $settings->stock_management : false;
        }

        foreach ($orderItems as $item) {
            $productId = $item->product_id ?? $item->associatedModel->id ?? null;
            $sku = $item->product_sku ?? $item->id ?? null;
            $quantity = $item->qty ?? $item->quantity ?? 1;
            $attributes = $item->attributes ?? null;

            if (is_array($attributes)) {
                $attributes = $attributes[0] ?? null;
            }

            $product = Product::find($productId);
            if (!$product) continue;

            // 1. Variant-based Stock Management (Regular Product)
            if ($product->has_variant == 1 && $attributes) {
                $productVariant = ProductVariant::with('items')
                    ->where('product_id', $product->id)
                    ->where('sku', $sku)
                    ->first();

                if ($productVariant) {
                    $productVariant->decrement('stock', $quantity);
                    $product->decrement('stock', $quantity);
                }
            }
            // 2. Package / Combo / Regular Stock Management
            else {
                if ($product->is_package == 1) {
                    $product->decrement('stock', $quantity * ($product->package_qty ?? 1));
                } elseif ($product->is_combo == 1) {
                    $comboItems = method_exists($item, 'orderComboItems') && $item->orderComboItems->count() > 0
                        ? $item->orderComboItems
                        : $product->comboItems;

                    foreach ($comboItems as $comboItem) {
                        $childProduct = Product::find($comboItem->product_id);
                        $childSku = $comboItem->sku ?? null;
                        $childVariantId = $comboItem->variant_id ?? null;
                        $childQty = ($comboItem->qty ?? $comboItem->quantity ?? 1) * $quantity;

                        if ($childProduct) {
                            // Combo child er variant thakle variant stock o minus hobe
                            if ($childVariantId) {
                                $childVariant = ProductVariant::find($childVariantId);
                                if ($childVariant) {
                                    $childVariant->decrement('stock', $childQty);
                                }
                            }

                            $childProduct->decrement('stock', $childQty);

                            if ($usePurchaseTableSetting) {
                                self::managePurchaseTableStock($childProduct, $childSku, $childQty, 'decrease');
                            }
                        }
                    }
                    $product->decrement('stock', $quantity);
                } else {
                    $product->decrement('stock', $quantity);
                }
            }

            if ($usePurchaseTableSetting && $product->is_combo != 1) {
                self::managePurchaseTableStock($product, $sku, $quantity, 'decrease');
            }
        }
    }

    public static function increaseStockForOrder($orderItems, $usePurchaseTableSetting = null)
    {
        if ($usePurchaseTableSetting === null) {
            $settings = WebSettings::first();
            $usePurchaseTableSetting = $settings ? $settings->stock_management : false;
        }

        foreach ($orderItems as $item) {
            $productId = $item->product_id ?? null;
            $sku = $item->product_sku ?? null;
            $quantity = $item->qty ?? 1;
            $attributes = $item->attributes ?? null;

            $product = Product::find($productId);
            if (!$product) continue;

            if ($product->has_variant == 1 && $attributes) {
                $productVariant = ProductVariant::where('product_id', $product->id)
                    ->where('sku', $sku)
                    ->first();

                if ($productVariant) {
                    $productVariant->increment('stock', $quantity);
                    $product->increment('stock', $quantity);
                }
            } else {
                if ($product->is_package == 1) {
                    $product->increment('stock', $quantity * ($product->package_qty ?? 1));
                } elseif ($product->is_combo == 1) {
                    $comboItems = method_exists($item, 'orderComboItems') && $item->orderComboItems->count() > 0
                        ? $item->orderComboItems
                        : $product->comboItems;

                    foreach ($comboItems as $comboItem) {
                        $childProduct = Product::find($comboItem->product_id);
                        $childSku = $comboItem->sku ?? null;
                        $childVariantId = $comboItem->variant_id ?? null;
                        $childQty = ($comboItem->qty ?? $comboItem->quantity ?? 1) * $quantity;

                        if ($childProduct) {
                            // Combo child er variant thakle variant stock o plus hobe
                            if ($childVariantId) {
                                $childVariant = ProductVariant::find($childVariantId);
                                if ($childVariant) {
                                    $childVariant->increment('stock', $childQty);
                                }
                            }

                            $childProduct->increment('stock', $childQty);

                            if ($usePurchaseTableSetting) {
                                self::managePurchaseTableStock($childProduct, $childSku, $childQty, 'increase');
                            }
                        }
                    }
                } else {
                    $product->increment('stock', $quantity);
                }
            }

            if ($usePurchaseTableSetting && $product->is_combo != 1) {
                self::managePurchaseTableStock($product, $sku, $quantity, 'increase');
            }
        }
    }

    private static function managePurchaseTableStock($product, $sku, $quantity, $type = 'decrease')
    {
        if ($type === 'decrease') {
            $purchaseItems = $product->get_purchase_items()
                ->when($sku, function ($q) use ($sku) {
                    return $q->where('sku', $sku);
                })
                ->where('stock_quantity', '>', 0)
                ->orderBy('sale_priority', 'desc')
                ->get();

            $remainingQty = $quantity;

            foreach ($purchaseItems as $purchaseItem) {
                if ($remainingQty <= 0) break;

                $deduct = min($purchaseItem->stock_quantity, $remainingQty);
                $purchaseItem->decrement('stock_quantity', $deduct);
                $remainingQty -= $deduct;
            }
        } else {
            $purchaseItem = $product->get_purchase_items()
                ->when($sku, function ($q) use ($sku) {
                    return $q->where('sku', $sku);
                })
                ->orderBy('sale_priority', 'desc')
                ->first();

            if ($purchaseItem) {
                $purchaseItem->increment('stock_quantity', $quantity);
            }
        }
    }
    public static function managePurchaseTableStockStatic($product, $sku, $quantity, $type = 'increase')
    {
        $settings = WebSettings::first();
        $usePurchaseTableSetting = $settings ? $settings->stock_management : false;

        if (!$usePurchaseTableSetting) {
            return;
        }

        if ($type === 'decrease') {
            $purchaseItems = $product->get_purchase_items()
                ->when($sku, function ($q) use ($sku) {
                    return $q->where('sku', $sku);
                })
                ->where('stock_quantity', '>', 0)
                ->orderBy('sale_priority', 'desc')
                ->get();

            $remainingQty = $quantity;

            foreach ($purchaseItems as $purchaseItem) {
                if ($remainingQty <= 0) break;

                $deduct = min($purchaseItem->stock_quantity, $remainingQty);
                $purchaseItem->decrement('stock_quantity', $deduct);
                $remainingQty -= $deduct;
            }
        } else {
            $purchaseItem = $product->get_purchase_items()
                ->when($sku, function ($q) use ($sku) {
                    return $q->where('sku', $sku);
                })
                ->orderBy('sale_priority', 'desc')
                ->first();

            if ($purchaseItem) {
                $purchaseItem->increment('stock_quantity', $quantity);
            }
        }
    }

    public static function getPurchasePrice($product, $sku = null, $attributes = null)
    {
        $settings = WebSettings::first();
        $usePurchaseTable = $settings ? $settings->stock_management : false;

        $purchase_price = 0;

        if ($usePurchaseTable && $product) {
            //  dd($product, $sku, $attributes);
            $purchaseItem = $product->get_purchase_items()
                ->when($sku, function ($q) use ($sku) {
                    return $q->where('sku', $sku);
                })
                ->where('stock_quantity', '>', 0)
                ->orderBy('sale_priority', 'desc')
                ->first();
            // dd($purchaseItem);

            $purchase_price = $purchaseItem->purchase_cost ?? null;
        }
        // dd($purchase_price);

        if (empty($purchase_price)) {
            // dd($product, $sku, $attributes);
            if ($attributes && $sku) {
                $purchase_price = ProductVariant::where('product_id', $product->id)
                    ->where('sku', $sku)
                    ->value('purchase_price') ?? 0;
            }
            if (empty($purchase_price)) {
                $purchase_price = $product->purchase_price ?? 0;
            }
        }
        //  dd($purchase_price);
        return $purchase_price;
    }
}
