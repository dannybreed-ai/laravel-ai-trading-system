@extends('layouts.app')
@section('title', 'Manage Deposits')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-8">Manage Deposits</h1>
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($deposits as $deposit)
                    <tr>
                        <td class="px-6 py-4 text-sm">{{ $deposit->user->name }}</td>
                        <td class="px-6 py-4 text-sm font-semibold">${{ number_format($deposit->amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm">{{ ucfirst($deposit->method) }}</td>
                        <td class="px-6 py-4"><span class="px-2 text-xs rounded-full {{ $deposit->status === 'approved' ? 'bg-green-100 text-green-800' : ($deposit->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">{{ ucfirst($deposit->status) }}</span></td>
                        <td class="px-6 py-4 text-sm">{{ $deposit->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($deposit->status === 'pending')
                                <form action="{{ route('admin.deposits.approve', $deposit) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Approve</button>
                                </form>
                                <button onclick="showRejectForm({{ $deposit->id }})" class="text-red-600 hover:text-red-900">Reject</button>
                                <form id="reject-form-{{ $deposit->id }}" action="{{ route('admin.deposits.reject', $deposit) }}" method="POST" class="hidden mt-2">
                                    @csrf
                                    <input type="text" name="rejection_reason" placeholder="Reason" required class="px-2 py-1 border rounded text-sm">
                                    <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded text-sm">Confirm</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">No deposits</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $deposits->links() }}</div>
</div>
<script>
function showRejectForm(id) {
    document.getElementById('reject-form-' + id).classList.remove('hidden');
}
</script>
@endsection
