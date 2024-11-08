@extends('Admin.layouts.main')

@section("title", "Users - All")

@section('content')

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive p-2">
            <table class="table table-bordered" width="100%" cellspacing="0" style="white-space: nowrap;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Invitation Code</th>
                        <th>Invites Count</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->invitation_code }}</td>
                            @php
                                $referred = App\Models\User::where('used_invitation_code', $user->invitation_code)->get();
                            @endphp
                            <td>{{ count($referred) }}</td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">All Orders</h1>
    <h3>Orders: </h3>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive p-2">
            <table class="table table-bordered" width="100%" cellspacing="0" style="white-space: nowrap;">
                <thead>
                    <tr>
                        <th>Ordered by</th>
                        <th>User Account Type</th>
                        <th>Recipient Name</th>
                        <th>Recipient Phone</th>
                        <th>Recipient Address</th>
                        <th>Sub Total</th>
                        <th>Sell Price</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->user ? $order->user->name : "Missing" }}</td>
                            <td>{{ $order->user_type }}</td>
                            <td>{{ $order->recipient_name }}</td>
                            <td>{{ $order->recipient_phone }}</td>
                            <td>{{ $order->recipient_address }}</td>
                            <td>{{ $order->sub_total }}</td>
                            <td>{{ $order->total_sell_price }}</td>
                            <td>{{ $order->status == 1 ? "Under Review" : ($order->status == 2 ? "Confirmed" : ($order->status == 3 ? "On Shipping" : ($order->status == 4 ? "Completed" : ($order->status == 0 ? "Canceled" : "Undifiened")))) }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>
                                <a href="{{ route("admin.orders.order.details", ["id" => $order->id]) }}" class="btn btn-success">Show</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($orders->hasPages())
        <div class="d-flex laravel_pagination mt-5">
            {!! $orders->links() !!}
        </div>
        @endif

    </div>
</div>



@endsection

