<?php
namespace App\Services;

use App\Models\Customer;

class CustomerService
{
    public function getAllCustomers()
    {
        return Customer::all();
    }

    public function storeCustomer($data)
    {
        Customer::create($data);
    }

    public function getCustomerById($id)
    {
        return Customer::findOrFail($id);
    }

    public function updateCustomer($id, $data)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($data);
    }

    public function deleteCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
    }
}
