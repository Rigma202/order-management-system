<?php
namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use Illuminate\Http\Request;
use App\Services\CustomerService;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        $customers = $this->customerService->getAllCustomers();
        return view('customer.index', compact('customers'));
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(CustomerRequest $request)
    {

        $this->customerService->storeCustomer($request->validated());
        return redirect()->route('customers.index');
    }

    public function edit($id)
    {
        $customer = $this->customerService->getCustomerById($id);

        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $this->customerService->updateCustomer($id, $request->all());

        return redirect()->route('customers.index');
    }

    public function destroy($id)
    {
        $this->customerService->deleteCustomer($id);

        return redirect()->route('customers.index');
    }
}
