<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'account_type',
        'bkash_no',
        'nagad_no',
        'rocket_no',
        'bank_name',
        'branch_name',
        'routing_no',
        'bank_account_no',
        'bank_account_name',
        'status',
        'is_default',
        'balance',
    ];

    public function get_account_transactions()
    {
        return $this->hasMany(AccountTransaction::class, 'account_id', 'id');
    }
    public function get_account_name()
    {
        if ($this->account_type == 2) {
            return 'Bkash ' . '(' . $this->bkash_no . ')'; //$this->bkash_no;
        } elseif ($this->account_type == 3) {
            return 'Nagad' . '(' . $this->nagad_no . ')'; //$this->nagad_no;
        } elseif ($this->account_type == 4) {
            return 'Rocket' . '(' . $this->rocket_no . ')'; //$this->rocket_no;
        } elseif ($this->account_type == 1) {
            return $this->bank_name . '(' . $this->bank_account_no . ')'; //$this->bank_account_no;
        } else {
            return '';
        }
    }
}
