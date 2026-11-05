<?php
// path: app/Observers/OrderAssignObserver.php

namespace App\Observers;

use App\Admin;
use App\OrderAssign;
use App\Services\OrderActivityLogger;

class OrderAssignObserver
{
    public function created(OrderAssign $orderAssign)
    {
        $employeeName = $orderAssign->get_employee->name ?? ('Employee #' . $orderAssign->employee_id);
        OrderActivityLogger::log($orderAssign->order_id, 'assigned', [
            'field'     => 'assigned_employee',
            'new_value' => $employeeName,
            'text'      => sprintf('অর্ডারটি "%s"-কে assign করা হয়েছে', $employeeName),
        ]);
    }

    public function updated(OrderAssign $orderAssign)
    {
        if (! $orderAssign->isDirty('employee_id')) {
            return;
        }

        $oldEmployeeId = $orderAssign->getOriginal('employee_id');
        $newEmployeeId = $orderAssign->getAttribute('employee_id');

        $oldEmployeeName = Admin::find($oldEmployeeId)->name ?? ('Employee #' . $oldEmployeeId);
        $newEmployeeName = Admin::find($newEmployeeId)->name ?? ('Employee #' . $newEmployeeId);

        // dd($oldEmployeeId, $newEmployeeId, $oldEmployeeName, $newEmployeeName);

        OrderActivityLogger::log($orderAssign->order_id, 'reassigned', [
            'field'     => 'assigned_employee',
            'old_value' => $oldEmployeeName,
            'new_value' => $newEmployeeName,
            'text'      => sprintf('অর্ডারটি reassign করা হয়েছে: Employee #%s → #%s', $oldEmployeeId, $newEmployeeId),
        ]);
    }
}
