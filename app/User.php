<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be treated as Carbon instances.
     *
     * @var array
     */
    protected $dates = [
        'trial_ends_at'
    ];

    /**
     * @return float
     */
    public function taxPercentage() {
        return 14.97;
    }

    public function getJsonInvoicesAttribute()
    {
        $invoices = $this->invoices()->map(function($invoice) {
            return [
                'date' => $invoice->date()->toFormattedDateString(),
                'total' => number_format($invoice->total / 100, 2, '.', ','),
                'download' => '/settings/billing/invoice/' . $invoice->id,
            ];
        });

        return $invoices;
    }
}
