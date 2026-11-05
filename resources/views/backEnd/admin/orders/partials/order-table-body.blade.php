                  @include('backEnd.admin.includes.top-paginate', ['items' => $orders])
                  <table class="datatable table table-vcenter card-table order-table">
                      <thead>
                          <tr>
                              <th class="w-1">
                                  SL. <input class="form-check-input m-0 align-middle" type="checkbox"
                                      aria-label="Select all invoices" id="master">
                              </th>
                              {{-- <th></th> --}}
                              <th>Invoice & Date</th>
                              <th>Customer Info</th>
                              <th>Activity</th>
                              <th>Products</th>
                              <th style="width: 10%">Amount</th>
                              <th>Courier</th>
                              {{-- <th>Date</th> --}}
                              <th>payment</th>
                              <th>Status</th>
                              <th style="width: 10%">Notes</th>
                              <th>Assigned</th>
                              <th>Actions</th>
                          </tr>
                      </thead>
                      <tbody>
                          {{-- @dd($orders) --}}
                          @php($i = 1)
                          @if ($orders->count() > 0)
                              @foreach ($orders as $item)
                                  <tr id="tr_{{ $item->id }}" class="{{ $item->is_duplicate ? 'table-danger' : '' }}"
                                      @if ($i % 2 == 0) style="background-color:#f5f5f5" @endif>
                                      <td class="sl-cell">
                                          {{ $i++ }}.
                                          <input class="form-check-input m-0 align-middle sub_chk" type="checkbox"
                                              data-id="{{ $item->id }}">
                                      </td>
                                      {{-- <td class="w-1">{{ $i++ }}</td> --}}

                                      <td style="width: 10%;">
                                          <div class="d-flex flex-column gap-1">

                                              <!-- 1. Source Badge -->
                                              <div>
                                                  <span class="badge {{ $item->source_color }} badge-sm">
                                                      {{ $item->source_name }}
                                                  </span>
                                              </div>

                                              <!-- 2. Invoice ID -->
                                              <div>
                                                  <span class="fw-bold text-dark font-monospace"
                                                      style="font-size: 0.88rem;">
                                                      #{{ $item->invoice_id }}
                                                  </span>
                                              </div>

                                              <!-- 3. Date -->
                                              <div class="text-muted small d-flex align-items-center gap-1"
                                                  style="font-size: 0.78rem;">
                                                  <i class="ti ti-calendar fs-6 opacity-75"></i>
                                                  <span>{{ date('d M, Y', strtotime($item->order_date)) }}</span>
                                              </div>

                                              <!-- 4. Time -->
                                              <div class="text-muted small d-flex align-items-center gap-1"
                                                  style="font-size: 0.78rem;">
                                                  <i class="ti ti-clock fs-6 opacity-75"></i>
                                                  <small>{{ date('h:i A', strtotime($item->created_at)) }}</small>
                                              </div>

                                          </div>
                                      </td>

                                      <td style="width: 18%;">
                                          <div
                                              class="customer-info-card p-1 rounded bg-light-subtle border border-dashed d-flex flex-column">

                                              <!-- Primary Info: Customer Name & Phone -->
                                              <div class="d-flex flex-column gap-1  border-bottom border-light-subtle ">
                                                  <!-- Customer Name -->
                                                  <div class="d-flex align-items-center gap-1">
                                                      <div class="avatar-initial rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center flex-shrink-0"
                                                          style="width: 26px; height: 26px;">
                                                          <i class="ti ti-user fs-6"></i>
                                                      </div>
                                                      <span class="text-dark fw-bold text-truncate"
                                                          style="font-size: 0.88rem;"
                                                          title="{{ $item->customer_name ?? 'N/A' }}">
                                                          {{ $item->customer_name ?? 'N/A' }}
                                                      </span>
                                                  </div>

                                                  <!-- Phone Number & Modern Call Button -->
                                                  <div class="d-flex align-items-center justify-content-between ps-1  pb-1"
                                                      style="font-size: 0.83rem;">
                                                      <div class="d-flex align-items-center gap-1">
                                                          <i class="ti ti-phone text-success fs-6"></i>
                                                          <span class="order-phone fw-semibold font-monospace text-dark"
                                                              data-phone="{{ $item->customer_phone }}">
                                                              {{ $item->customer_phone ?? 'N/A' }}
                                                          </span>
                                                      </div>
                                                      @if (!empty($item->customer_phone))
                                                          <a href="tel:{{ $item->customer_phone }}"
                                                              class="btn btn-sm rounded-pill px-2.5 py-1 d-inline-flex align-items-center gap-1 text-white shadow-sm"
                                                              style="background: linear-gradient(135deg, #198754 0%, #20c997 100%); font-size: 0.73rem; height: 22px; transition: all 0.2s ease-in-out;"
                                                              onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 .3rem .5rem rgba(25, 135, 84, 0.3)'"
                                                              onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 .125rem .25rem rgba(0, 0, 10, 0.075)'"
                                                              title="Call Customer">
                                                              <i class="ti ti-phone-call"
                                                                  style="font-size: 0.75rem;"></i>
                                                              <span class="fw-medium">Call</span>
                                                          </a>
                                                      @endif
                                                  </div>
                                              </div>

                                              <!-- Secondary Info: Technical & Location Metadata -->
                                              <div class="d-flex flex-column gap-1" style="font-size: 0.8rem;">
                                                  <!-- Address -->
                                                  <div class="d-flex align-items-start gap-1 text-muted border-bottom border-light-subtle  py-1"
                                                      style="line-height: 1.25;">
                                                      <i class="ti ti-map-pin text-danger flex-shrink-0"></i>
                                                      <span class="text-wrap text-break text-secondary"
                                                          style="font-size: 0.77rem;">
                                                          {{ $item->customer_address ?? 'N/A' }}
                                                      </span>
                                                  </div>
                                                  <!-- Device ID -->
                                                  <div
                                                      class="d-flex align-items-center justify-content-between text-muted">
                                                      <span class="d-flex align-items-center gap-1">
                                                          <i class="ti ti-device-laptop text-secondary"></i> Device:
                                                      </span>
                                                      <span class="font-monospace text-dark text-truncate"
                                                          style="max-width: 120px;">
                                                          <a href="{{ route('admin.device', ['search' => $item->device_id]) }}"
                                                              class="text-decoration-none text-dark hover-primary fw-medium"
                                                              title="{{ $item->device_id ?? 'N/A' }}">
                                                              {{ $item->device_id ?? '--' }}
                                                          </a>
                                                      </span>
                                                  </div>

                                                  <!-- IP Address -->
                                                  <div
                                                      class="d-flex align-items-center justify-content-between text-muted">
                                                      <span class="d-flex align-items-center gap-1">
                                                          <i class="ti ti-network text-secondary"></i> IP:
                                                      </span>
                                                      <span class="font-monospace text-dark text-truncate"
                                                          style="max-width: 120px;">
                                                          <a href="{{ route('admin.ip.address', ['search' => $item->ip_address]) }}"
                                                              class="text-decoration-none text-dark hover-primary fw-medium"
                                                              title="{{ $item->ip_address ?? 'N/A' }}">
                                                              {{ $item->ip_address ?? '--' }}
                                                          </a>
                                                      </span>
                                                  </div>


                                              </div>

                                          </div>
                                      </td>
                                      <td>
                                          <?php
                                          $summary = $item->customer_activity['totalSummary'] ?? [];
                                          $successRate = (int) ($summary['successRate'] ?? 0);
                                          
                                          // Success Rate অনুযায়ী ডাইনামিক কালার এবং ব্যাজ ক্লাস
                                          $badgeClass = $successRate >= 70 ? 'bg-success-subtle text-success border-success' : ($successRate >= 30 ? 'bg-warning-subtle text-warning border-warning' : 'bg-danger-subtle text-danger border-danger');
                                          ?>

                                          {{-- Circle Chart Trigger Button --}}
                                          <div class="d-flex align-items-center justify-content-center">
                                              <a href="javascript:void(0)"
                                                  class="customer_activity_btn d-inline-block transition-hover"
                                                  data-total="{{ $summary['total'] ?? 0 }}"
                                                  data-total_delivered="{{ $summary['success'] ?? 0 }}"
                                                  data-total_returned="{{ $summary['cancel'] ?? 0 }}"
                                                  data-bs-toggle="modal"
                                                  data-bs-target="#courierDetailsModal_{{ $item->id }}"
                                                  title="Click to view courier details">
                                                  <canvas class="successChart" data-rate="{{ $successRate }}"
                                                      width="65" height="65"
                                                      data-orders="{{ $summary['total'] ?? 0 }} Order"></canvas>
                                              </a>
                                          </div>

                                          <!-- Courier Details Modal -->
                                          <div class="modal fade" id="courierDetailsModal_{{ $item->id }}"
                                              tabindex="-1" aria-hidden="true">
                                              <div class="modal-dialog modal-lg modal-dialog-centered">
                                                  <div class="modal-content border-0 shadow-lg">

                                                      {{-- Modal Header --}}
                                                      <div class="modal-header bg-primary text-white">
                                                          <div class="d-flex align-items-center gap-2">
                                                              <i class="ti ti-truck-delivery fs-3 text-warning"></i>
                                                              <h5 class="modal-title m-0 fw-semibold">
                                                                  {{ $item->customer_name }}
                                                              </h5>
                                                          </div>

                                                          <div class="d-flex align-items-center gap-2">
                                                              {{-- Fraud Checker / Refresh Button --}}
                                                              <a href="{{ route('admin.fraud.checker', $item->id) }}"
                                                                  class="btn btn-sm btn-icon {{ $badgeClass }} border d-inline-flex align-items-center justify-content-center p-1"
                                                                  title="Re-check Courier Data"
                                                                  style="width: 25px; height: 25px; border-radius: 3px;">
                                                                  <i class="ti ti-refresh fs-5"></i>
                                                              </a>

                                                              <button type="button" class="btn-close btn-close-white"
                                                                  data-bs-dismiss="modal" aria-label="Close"></button>
                                                          </div>
                                                      </div>

                                                      {{-- Modal Body --}}
                                                      <div class="modal-body p-4">
                                                          {{-- Summary Overview Cards --}}
                                                          <div class="row g-2 mb-3">
                                                              <div class="col-4">
                                                                  <div class="p-2 border rounded bg-light text-center">
                                                                      <span class="text-muted small d-block">Total
                                                                          Orders</span>
                                                                      <strong
                                                                          class="fs-5 text-dark">{{ $summary['total'] ?? 0 }}</strong>
                                                                  </div>
                                                              </div>
                                                              <div class="col-4">
                                                                  <div
                                                                      class="p-2 border border-success-subtle bg-success-subtle rounded text-center">
                                                                      <span
                                                                          class="text-success small d-block">Delivered</span>
                                                                      <strong
                                                                          class="fs-5 text-success">{{ $summary['success'] ?? 0 }}</strong>
                                                                  </div>
                                                              </div>
                                                              <div class="col-4">
                                                                  <div
                                                                      class="p-2 border border-danger-subtle bg-danger-subtle rounded text-center">
                                                                      <span
                                                                          class="text-danger small d-block">Cancelled</span>
                                                                      <strong
                                                                          class="fs-5 text-danger">{{ $summary['cancel'] ?? 0 }}</strong>
                                                                  </div>
                                                              </div>
                                                          </div>

                                                          {{-- Details Table --}}
                                                          <div class="table-responsive rounded border">
                                                              <table
                                                                  class="table table-hover table-striped align-middle m-0">
                                                                  <thead class="table-light">
                                                                      <tr>
                                                                          <th class="py-2">Courier Name</th>
                                                                          <th class="py-2 text-center">Total</th>
                                                                          <th class="py-2 text-center text-success">
                                                                              Delivered</th>
                                                                          <th class="py-2 text-center text-danger">
                                                                              Cancelled</th>
                                                                          <th class="py-2 text-end">Success Rate
                                                                          </th>
                                                                      </tr>
                                                                  </thead>
                                                                  <tbody>
                                                                      @if (!empty($item->customer_activity['Summaries']))
                                                                          @foreach ($item->customer_activity['Summaries'] as $courierName => $courier)
                                                                              <?php
                                                                              $cTotal = $courier['total'] ?? 0;
                                                                              $cSuccess = $courier['success'] ?? 0;
                                                                              $cRatio = $cTotal > 0 ? round(($cSuccess / $cTotal) * 100, 1) : 0;
                                                                              ?>
                                                                              <tr>
                                                                                  <td
                                                                                      class="fw-semibold text-capitalize text-dark">
                                                                                      {{ $courierName }}
                                                                                  </td>
                                                                                  <td
                                                                                      class="text-center font-monospace">
                                                                                      {{ $cTotal }}</td>
                                                                                  <td
                                                                                      class="text-center font-monospace text-success fw-bold">
                                                                                      {{ $cSuccess }}</td>
                                                                                  <td
                                                                                      class="text-center font-monospace text-danger">
                                                                                      {{ $courier['cancel'] ?? 0 }}
                                                                                  </td>
                                                                                  <td class="text-end">
                                                                                      <span
                                                                                          class="badge {{ $cRatio >= 70 ? 'bg-success' : ($cRatio >= 30 ? 'bg-warning' : 'bg-danger') }}">
                                                                                          {{ number_format($cRatio, 2) }}%
                                                                                      </span>
                                                                                  </td>
                                                                              </tr>
                                                                          @endforeach
                                                                      @else
                                                                          <tr>
                                                                              <td colspan="5"
                                                                                  class="text-center py-4 text-muted">
                                                                                  <i
                                                                                      class="ti ti-alert-circle fs-3 d-block mb-1 opacity-50"></i>
                                                                                  No detailed courier information
                                                                                  available.
                                                                              </td>
                                                                          </tr>
                                                                      @endif
                                                                  </tbody>
                                                              </table>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </td>
                                      <td style="width: 30%;">
                                          <div class="d-flex flex-column gap-1 p-1">
                                              @foreach ($item->get_products as $product)
                                                  <?php
                                                  $prod = $product->get_product;
                                                  //   dd($prod);
                                                  $thumbUrl = $prod->get_thumb->file_url ?? null;
                                                  $comboItems = $product->orderComboItems ?? collect();
                                                  ?>
                                                  <div
                                                      class="d-flex flex-column gap-2 p-2 rounded-2 bg-white border border-light shadow-sm position-relative transition-all hover-shadow">

                                                      <div class="d-flex align-items-center gap-2">
                                                          <!-- Product Image / Placeholder -->
                                                          <div class="flex-shrink-0 position-relative">
                                                              @if ($thumbUrl)
                                                                  <img src="{{ asset($thumbUrl) }}"
                                                                      alt="{{ $prod->name }}"
                                                                      class="image-modal-trigger rounded-2 border object-fit-cover cursor-pointer shadow-xs"
                                                                      style="width: 44px; height: 44px;"
                                                                      data-src="{{ asset($thumbUrl) }}"
                                                                      data-bs-toggle="modal"
                                                                      data-bs-target="#imageModal"
                                                                      title="Click to view">
                                                              @else
                                                                  <div class="bg-light border rounded-2 d-flex align-items-center justify-content-center text-muted"
                                                                      style="width: 44px; height: 44px;"
                                                                      title="No image available">
                                                                      <i class="ti ti-photo-off fs-5 opacity-50"></i>
                                                                  </div>
                                                              @endif
                                                              <!-- Quantity Badge Overlay -->
                                                              <span
                                                                  class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-white"
                                                                  style="font-size: 0.65rem; padding: 0.25em 0.4em;">
                                                                  {{ $product->qty }}x
                                                              </span>
                                                          </div>

                                                          <!-- Product Details -->
                                                          <div class="flex-grow-1 min-w-0 d-flex flex-column gap-1">

                                                              <!-- Title & Discount Row -->
                                                              <div class="d-flex align-items-center justify-content-between gap-1"
                                                                  style="max-width:200px;">
                                                                  <a href="{{ route('single.product', $prod->slug) }}"
                                                                      target="_blank"
                                                                      class="text-dark fw-semibold  text-decoration-none"
                                                                      style="font-size: 0.85rem;"
                                                                      title="{{ $prod->name }}">
                                                                      {{ $prod->name }}
                                                                      {{-- @dd($prod) --}}
                                                                      @if ($prod->is_combo == 1)
                                                                          <span class="badge bg-purple-lt">Combo
                                                                              Pack</span>
                                                                      @endif
                                                                  </a>

                                                                  @if ($product->discount > 0)
                                                                      <span
                                                                          class="badge bg-warning-subtle text-warning fw-semibold px-1.5 py-0.5 flex-shrink-0"
                                                                          style="font-size: 0.68rem;">
                                                                          -{{ $product->discount }}
                                                                      </span>
                                                                  @endif
                                                              </div>

                                                              <!-- SKU & Dynamic Attributes / Variants -->
                                                              <div class="d-flex align-items-center flex-wrap gap-2 text-muted"
                                                                  style="font-size: 0.75rem;">
                                                                  @if ($prod->sku)
                                                                      <span class="font-monospace text-secondary">
                                                                          SKU: <strong
                                                                              class="text-dark">{{ $prod->sku }}</strong>
                                                                      </span>
                                                                  @endif

                                                                  <!-- Dynamic Attributes / Variants -->
                                                                  @if (!empty($product->formatted_attributes_list) && $product->formatted_attributes_list->count() > 0)
                                                                      <div class="d-inline-flex gap-1 flex-wrap">
                                                                          @foreach ($product->formatted_attributes_list as $v_item)
                                                                              <span
                                                                                  class="badge bg-light text-dark border fw-normal px-1.5 py-0.5"
                                                                                  style="font-size: 0.7rem;">
                                                                                  <span
                                                                                      class="text-muted">{{ $v_item->attribute->name ?? '' }}:</span>
                                                                                  <strong
                                                                                      class="text-dark">{{ $v_item->name }}</strong>
                                                                              </span>
                                                                          @endforeach
                                                                      </div>
                                                                  @endif
                                                              </div>

                                                          </div>
                                                      </div>

                                                      <!-- Combo Included Items Sub-Design -->
                                                      @if ($comboItems->count() > 0)
                                                          <div
                                                              class="mt-1 pt-1 border-top border-light-subtle bg-light-subtle p-1.5 rounded-1">
                                                              <div class="text-secondary fw-bold text-uppercase mb-1"
                                                                  style="font-size: 0.68rem; letter-spacing: 0.5px;">
                                                                  Combo Items:
                                                              </div>
                                                              <div class="d-flex flex-column gap-1">
                                                                  @foreach ($comboItems as $cItem)
                                                                      <div class="d-flex align-items-center justify-content-between text-muted"
                                                                          style="font-size: 0.73rem;">
                                                                          <span class="text-dark text-truncate"
                                                                              style="max-width: 170px;"
                                                                              title="{{ $cItem->product->name ?? 'N/A' }}">
                                                                              {{ $cItem->product->name ?? 'N/A' }}
                                                                              @if ($cItem->sku)
                                                                                  <span
                                                                                      class="font-monospace text-secondary">({{ $cItem->sku }})</span>
                                                                              @endif
                                                                              @if ($cItem->variant_name)
                                                                                  <span
                                                                                      class="badge bg-light text-dark border px-1 py-0 ms-1"
                                                                                      style="font-size: 0.65rem;">
                                                                                      {{ $cItem->variant_name }}
                                                                                  </span>
                                                                              @endif
                                                                          </span>
                                                                          <span
                                                                              class="badge bg-white text-dark border px-1 py-0"
                                                                              style="font-size: 0.65rem;">
                                                                              Qty: {{ $cItem->qty }}
                                                                          </span>
                                                                      </div>
                                                                  @endforeach
                                                              </div>
                                                          </div>
                                                      @endif

                                                  </div>
                                              @endforeach
                                          </div>
                                      </td>
                                      </div>
                                      </td>

                                      {{-- <td>{{ $web_settings->currency_sign }} {{ $item->total }}</td> --}}
                                      <td>
                                          <div class="d-flex flex-column gap-1 p-2 rounded bg-light-subtle border border-dashed"
                                              style="min-width: 150px; font-size: 0.80rem;">

                                              <!-- Sub Total -->
                                              <div class="d-flex justify-content-between align-items-center">
                                                  <span class="text-muted">Sub:</span>
                                                  <span
                                                      class="fw-semibold">{{ 0 + number_format($item->sub_total, 2, '.', '') }}</span>
                                              </div>

                                              <!-- Item Discount -->
                                              @if ($item->discount > 0)
                                                  <div
                                                      class="d-flex justify-content-between align-items-center text-danger">
                                                      <span>Dis:</span>
                                                      <span
                                                          class="fw-semibold">-{{ 0 + number_format($item->discount, 2, '.', '') }}</span>
                                                  </div>
                                              @endif

                                              <!-- Coupon Discount -->
                                              @if ($item->coupon_discount > 0)
                                                  <div
                                                      class="d-flex justify-content-between align-items-center text-danger">
                                                      <span>C.Dis:</span>
                                                      <span
                                                          class="fw-semibold">-{{ 0 + number_format($item->coupon_discount, 2, '.', '') }}</span>
                                                  </div>
                                              @endif

                                              <!-- Delivery Charge -->
                                              <div class="d-flex justify-content-between align-items-center">
                                                  <span class="text-muted">D. Charge:</span>
                                                  <span
                                                      class="fw-semibold">{{ 0 + number_format($item->shipping_cost, 2, '.', '') }}</span>
                                              </div>




                                              <hr class="my-1 border-secondary-subtle">

                                              <!-- Total -->
                                              <div class="d-flex justify-content-between align-items-center fw-bold">
                                                  <span class="text-dark">Total:</span>
                                                  <span
                                                      class="text-dark">{{ 0 + number_format($item->total, 2, '.', '') }}</span>
                                              </div>

                                              <!-- Paid Amount -->
                                              <div
                                                  class="d-flex justify-content-between align-items-center text-success">
                                                  <span>Paid:</span>
                                                  <span
                                                      class="fw-bold">{{ 0 + number_format($item->paid, 2, '.', '') }}</span>
                                              </div>

                                              <!-- Due Amount -->
                                              <div
                                                  class="d-flex justify-content-between align-items-center text-danger">
                                                  <span>Due:</span>
                                                  <span
                                                      class="fw-bold">{{ 0 + number_format($item->due, 2, '.', '') }}</span>
                                              </div>

                                          </div>
                                      </td>
                                      <!-- Courier Details -->
                                      <td style="min-width: 140px;" class="align-top">
                                          <?php
                                          $currentCity = '';
                                          $currentZone = '';
                                          $trackingUrl = null;
                                          
                                          if ((int) $item->courier_id === 2) {
                                              $currentCity = $pathaoCities[$item->courier_city_id] ?? '';
                                              $currentZone = $pathaoZones[$item->courier_zone_id] ?? '';
                                              if (!empty($item->consignment_id)) {
                                                  $trackingUrl = 'https://merchant.pathao.com/tracking?consignment_id=' . $item->consignment_id;
                                              }
                                          } elseif ((int) $item->courier_id === 1) {
                                              if (!empty($item->tracking_id)) {
                                                  $trackingUrl = $item->tracking_id;
                                              } elseif (!empty($item->consignment_id)) {
                                                  $trackingUrl = 'https://steadfast.com.bd/tl/' . $item->consignment_id;
                                              }
                                          } elseif ((int) $item->courier_id === 4) {
                                              $currentCity = $carrybeeCities[$item->courier_city_id] ?? '';
                                              $currentZone = $carrybeeZones[$item->courier_zone_id] ?? '';
                                              if (!empty($item->consignment_id)) {
                                                  $trackingUrl = 'https://merchant.carrybee.com/order-track/' . $item->consignment_id;
                                              }
                                          }
                                          ?>

                                          @if ($item->get_courier)
                                              <span
                                                  class="badge bg-info">{{ $item->get_courier->courier_name }}</span>
                                          @else
                                              <span class="text-muted small">--</span>
                                          @endif

                                          @if ($currentCity || $currentZone)
                                              <div class="mt-1 small text-muted text-truncate"
                                                  style="max-width: 130px;"
                                                  title="{{ $currentCity }} -> {{ $currentZone }}">
                                                  {{ $currentCity ?: 'N/A' }} @if ($currentZone)
                                                      &rarr; {{ $currentZone }}
                                                  @endif
                                              </div>
                                          @endif

                                          @if (!empty($item->consignment_id))
                                              <div class="mt-1 small fw-semibold">
                                                  @if ($trackingUrl)
                                                      <a href="{{ $trackingUrl }}" target="_blank" rel="noopener"
                                                          class="text-decoration-none">{{ $item->consignment_id }}</a>
                                                  @else
                                                      <span>{{ $item->consignment_id }}</span>
                                                  @endif
                                              </div>
                                          @endif
                                          @if (!empty($item->courier_status))
                                              <div class="mt-1 small text-dark"><span
                                                      class="text-capitalize badge bg-success">{{ $item->courier_status }}</span>
                                              </div>
                                          @endif
                                          {{-- // courier_reason_msg --}}
                                          @if (!empty($item->courier_reason_msg))
                                              <div class="mt-1 small text-danger"><span
                                                      class="text-capitalize">{{ $item->courier_reason_msg }}</span>
                                              </div>
                                          @endif
                                      </td>

                                      <!-- Payment Column -->
                                      <td>
                                          <?php
                                          $bgClass = $item->payment_status == 1 ? 'bg-success' : ($item->payment_status == 2 ? 'bg-primary' : 'bg-danger');
                                          ?>

                                          <span
                                              class="badge {{ $bgClass }} dropdown dropdown-toggle cursor-pointer"
                                              data-bs-toggle="dropdown">
                                              @if ($item->payment_status == 1)
                                                  Paid
                                              @endif
                                              @if ($item->payment_status == 0)
                                                  Unpaid
                                              @endif
                                              @if ($item->payment_status == 2)
                                                  Partial
                                              @endif
                                          </span>

                                          @can('orders.payment_status')
                                              <div class="dropdown-menu">
                                                  <!-- Paid Click -->
                                                  <a class="dropdown-item {{ $item->payment_status == 1 ? 'd-none' : '' }}"
                                                      href="javascript:void(0)"
                                                      onclick="confirmPaid('{{ route('admin.orders.payment', [$item->id, 1]) }}')">
                                                      Paid
                                                  </a>

                                                  <!-- Unpaid Click -->
                                                  <a class="dropdown-item {{ $item->payment_status == 0 ? 'd-none' : '' }}"
                                                      href="{{ route('admin.orders.payment', [$item->id, 0]) }}">
                                                      Unpaid
                                                  </a>

                                                  <!-- Partial Click (Triggers Modal) -->
                                                  <a class="dropdown-item {{ $item->payment_status == 2 ? 'd-none' : '' }}"
                                                      href="javascript:void(0)"
                                                      onclick="openPartialModal({{ $item->id }}, {{ $item->due > 0 ? $item->due : $item->total }}, {{ $item->paid ?? 0 }})">
                                                      Partial
                                                  </a>
                                              </div>
                                          @endcan
                                      </td>
                                      <style>
                                          .order-status-select {
                                              min-width: 145px;
                                              height: 34px;
                                              padding: 4px 30px 4px 12px;
                                              border: 0 !important;
                                              border-radius: 20px;
                                              font-size: 12px;
                                              font-weight: 600;
                                              cursor: pointer;
                                              outline: none !important;
                                              box-shadow: none !important;
                                              transition: all .2s ease;
                                              appearance: auto;
                                          }

                                          .order-status-select:hover {
                                              transform: translateY(-1px);
                                              box-shadow: 0 2px 8px rgba(0, 0, 0, .08) !important;
                                          }

                                          .order-status-select:focus {
                                              box-shadow: 0 0 0 2px rgba(0, 0, 0, .08) !important;
                                          }


                                          /* Pending */
                                          .status-1 {
                                              background: #fff7e6 !important;
                                              color: #b7791f !important;
                                          }

                                          /* Confirm */
                                          .status-2 {
                                              background: #e8f4ff !important;
                                              color: #1971c2 !important;
                                          }

                                          /* Processing */
                                          .status-3 {
                                              background: #eef2ff !important;
                                              color: #4c51bf !important;
                                          }

                                          /* Hold */
                                          .status-4 {
                                              background: #f3f4f6 !important;
                                              color: #6b7280 !important;
                                          }

                                          /* Printed */
                                          .status-5 {
                                              background: #f3e8ff !important;
                                              color: #7e22ce !important;
                                          }

                                          /* Packaging */
                                          .status-6 {
                                              background: #fff4e6 !important;
                                              color: #d9480f !important;
                                          }

                                          /* Courier Entry */
                                          .status-7 {
                                              background: #e6fcf5 !important;
                                              color: #087f5b !important;
                                          }

                                          /* On Delivery */
                                          .status-8 {
                                              background: #e7f5ff !important;
                                              color: #1864ab !important;
                                          }

                                          /* Delivered */
                                          .status-9 {
                                              background: #e6fcf5 !important;
                                              color: #087f5b !important;
                                          }

                                          /* Cancelled */
                                          .status-10 {
                                              background: #fff1f1 !important;
                                              color: #c92a2a !important;
                                          }

                                          /* Returned */
                                          .status-11 {
                                              background: #fff0f6 !important;
                                              color: #c2255c !important;
                                          }

                                          /* Return Received */
                                          .status-12 {
                                              background: #f3f0ff !important;
                                              color: #6741d9 !important;
                                          }

                                          /* Exchange */
                                          .status-13 {
                                              background: #e6fcf5 !important;
                                              color: #0b7285 !important;
                                          }
                                      </style>

                                      <td>
                                          @can('orders.status')
                                              <select
                                                  class="form-select form-select-sm order-status-select status-{{ $item->status }}"
                                                  data-order-id="{{ $item->id }}">
                                                  <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>
                                                      Pending
                                                  </option>

                                                  <option value="2" {{ $item->status == 2 ? 'selected' : '' }}>
                                                      Confirm
                                                  </option>

                                                  <option value="3" {{ $item->status == 3 ? 'selected' : '' }}>
                                                      Processing
                                                  </option>

                                                  <option value="4" {{ $item->status == 4 ? 'selected' : '' }}>
                                                      Hold
                                                  </option>

                                                  <option value="5" {{ $item->status == 5 ? 'selected' : '' }}>
                                                      Printed
                                                  </option>

                                                  <option value="6" {{ $item->status == 6 ? 'selected' : '' }}>
                                                      Packaging
                                                  </option>

                                                  <option value="7" {{ $item->status == 7 ? 'selected' : '' }}>
                                                      Courier Entry
                                                  </option>

                                                  <option value="8" {{ $item->status == 8 ? 'selected' : '' }}>
                                                      On Delivery
                                                  </option>

                                                  <option value="9" {{ $item->status == 9 ? 'selected' : '' }}>
                                                      Delivered
                                                  </option>


                                                  <option value="10" {{ $item->status == 10 ? 'selected' : '' }}>
                                                      Cancelled
                                                  </option>

                                                  <option value="11" {{ $item->status == 11 ? 'selected' : '' }}>
                                                      Returned
                                                  </option>

                                                  <option value="12" {{ $item->status == 12 ? 'selected' : '' }}>
                                                      Return Received
                                                  </option>

                                                  <option value="13" {{ $item->status == 13 ? 'selected' : '' }}>
                                                      Exchange
                                                  </option>
                                              </select>
                                          @endcan
                                      </td>
                                      <td style="min-width: 180px;">
                                          <?php
                                          $lastStaffNote = $item->get_staff_notes->last();
                                          $lastCustomerNote = $item->get_customer_notes->last();
                                          ?>

                                          <div class="notes-container d-flex flex-column gap-1">

                                              {{-- 1. Staff Note Section --}}
                                              <div class="border rounded p-1 bg-white shadow-xs">
                                                  <div
                                                      class="d-flex align-items-center justify-content-between mb-1 pb-1 border-bottom">
                                                      <span class="text-info fw-semibold font-monospace px-1 py-0"
                                                          style="font-size: 10px;">
                                                          S. Note
                                                      </span>
                                                      <div class="d-flex align-items-center gap-1">
                                                          {{-- Add Staff Note --}}
                                                          <a href="javascript:void(0)"
                                                              class="text-primary btn-note-action" data-action="add"
                                                              data-type="staff" data-order-id="{{ $item->id }}"
                                                              title="Add Staff Note">
                                                              <i class="ti ti-plus fs-5"></i>
                                                          </a>

                                                          @if ($lastStaffNote)
                                                              {{-- Edit Staff Note --}}
                                                              <a href="javascript:void(0)"
                                                                  class="text-warning btn-note-action"
                                                                  data-action="edit" data-type="staff"
                                                                  data-order-id="{{ $item->id }}"
                                                                  data-note-id="{{ $lastStaffNote->id }}"
                                                                  data-note-text="{{ $lastStaffNote->note }}"
                                                                  title="Edit Staff Note">
                                                                  <i class="ti ti-pencil fs-5"></i>
                                                              </a>
                                                          @endif

                                                          {{-- Staff Note History --}}
                                                          <a href="javascript:void(0)"
                                                              class="text-info btn-note-history" data-type="staff"
                                                              data-order-id="{{ $item->id }}"
                                                              title="View History">
                                                              <i class="ti ti-history fs-5"></i>
                                                          </a>
                                                      </div>
                                                  </div>
                                                  <div class="text-secondary text-break small lh-sm"
                                                      style="font-size: 0.78rem;">
                                                      {{ $lastStaffNote->note ?? 'No staff notes.' }}
                                                  </div>
                                              </div>

                                              {{-- 2. Customer Note Section --}}
                                              <div class="border rounded p-1 bg-white shadow-xs">
                                                  <div
                                                      class="d-flex align-items-center justify-content-between mb-1 pb-1 border-bottom">
                                                      <span class="text-info fw-semibold font-monospace px-1 py-0"
                                                          style="font-size: 10px;">
                                                          C. Note
                                                      </span>
                                                      <div class="d-flex align-items-center gap-1">
                                                          @if ($lastCustomerNote)
                                                              {{-- Edit Customer Note --}}
                                                              <a href="javascript:void(0)"
                                                                  class="text-warning btn-note-action"
                                                                  data-action="edit" data-type="customer"
                                                                  data-order-id="{{ $item->id }}"
                                                                  data-note-id="{{ $lastCustomerNote->id }}"
                                                                  data-note-text="{{ $lastCustomerNote->note }}"
                                                                  title="Edit Customer Note">
                                                                  <i class="ti ti-pencil fs-5"></i>
                                                              </a>
                                                          @endif

                                                          {{-- Customer Note History --}}
                                                          <a href="javascript:void(0)"
                                                              class="text-info btn-note-history" data-type="customer"
                                                              data-order-id="{{ $item->id }}"
                                                              title="View History">
                                                              <i class="ti ti-history fs-5"></i>
                                                          </a>
                                                      </div>
                                                  </div>
                                                  <div class="text-secondary text-break small lh-sm"
                                                      style="font-size: 0.78rem;">
                                                      {{ $lastCustomerNote->note ?? 'No customer notes.' }}
                                                  </div>
                                              </div>

                                          </div>
                                      </td>

                                      <td>
                                          {{ $item->get_assigned ? $item->get_assigned->get_employee->name : '' }}
                                      </td>

                                      <td class="w-1">
                                          @can('orders.print')
                                              <a href="javascript:void(0)"
                                                  class="btn-gradient-primary  padding-2-6  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1 print"
                                                  data-id="{{ $item->id }}">
                                                  <i class="ti ti-printer"></i>
                                                  Print
                                              </a>
                                          @endcan
                                          @can('orders.edit')
                                              <a href="{{ route('admin.orders.edit', $item->id) }}"
                                                  class="btn-gradient-info  padding-2-6  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1">
                                                  <i class="ti ti-edit"></i> Edit
                                              </a>
                                          @endcan

                                          @can('orders.delete')
                                              <a href="javascript:void(0)" data-id="{{ $item->id }}"
                                                  class="btn-gradient-success  padding-2-6  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1 order_activities">
                                                  <i class="ti ti-history"></i> Activies
                                              </a>
                                          @endcan

                                          @can('orders.delete')
                                              <a href="{{ route('admin.orders.delete', $item->id) }}"
                                                  class="btn-gradient-danger padding-2-6  border-0 btn-sm w-100 mb-1 d-flex justify-content-center align-items-center rounded gap-1"
                                                  onclick="return confirm('Are you sure to move this to trash?')">
                                                  <i class="ti ti-trash"></i>
                                                  Delete</a>
                                          @endcan

                                      </td>
                                  </tr>
                              @endforeach
                          @else
                              <tr>
                                  <td colspan="12" class="text-center text-danger font-weight-bold">No
                                      Data Found!
                                  </td>
                              </tr>
                          @endif

                      </tbody>
                  </table>
                  @include('backEnd.admin.includes.bottom-paginate', ['items' => $orders])
