<?php

namespace App\Http\Livewire;

use App\Models\CartOrder;
use Livewire\Component;
use Livewire\WithPagination;

class AdminCartOrder extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $status, $order,$shipping;

    public function Order($id)
    {
        $this->order = CartOrder::findOrFail($id);
        $this->shipping = $this->order->user->shippingInfo;
    }

    public function update()
    {
        $this->validate([
            'status' => 'required',
        ]);

        $this->order->update(['status' => $this->status]);
        session()->flash('message', 'Cart Order Updated');
        $this->reset();
        //Email User
    }
    public function render()
    {
        $orders = CartOrder::with('user','items')
            ->where('status', '!=', 'unverified')
            ->latest()
            ->search(trim($this->search))
            ->paginate(10);
        return view('livewire.admin-cart-order', [
            'orders' => $orders
        ]);
    }
}
