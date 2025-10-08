@extends('layouts.app')
@section('title', 'Manage Withdrawals')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-8">Manage Withdrawals</h1>
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Net</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($withdrawals as $withdrawal)
                    <tr>
                        <td class="px-6 py-4 text-sm">{{ $withdrawal->user->name }}</td>
                        <td class="px-6 py-4 text-sm">${{ number_format($withdrawal->amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm font-semibold">${{ number_format($withdrawal->net_amount, 2) }}</td>
                        <td class="px-6 py-4 text-sm">{{ ucfirst($withdrawal->method) }}</td>
                        <td class="px-6 py-4"><span class="px-2 text-xs rounded-full {{ $withdrawal->status === 'completed' ? 'bg-green-100 text-green-800' : ($withdrawal->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">{{ ucfirst($withdrawal->status) }}</span></td>
                        <td class="px-6 py-4 text-sm">
                            @if($withdrawal->status === 'pending')
                                <form action="{{ route('admin.withdrawals.approve', $withdrawal) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Approve</button>
                                </form>
                                <button onclick="showRejectForm({{ $withdrawal->id }})" class="text-red-600 hover:text-red-900">Reject</button>
                                <form id="reject-form-{{ $withdrawal->id }}" action="{{ route('admin.withdrawals.reject', $withdrawal) }}" method="POST" class="hidden mt-2">
                                    @csrf
                                    <input type="text" name="rejection_reason" placeholder="Reason" required class="px-2 py-1 border rounded text-sm">
                                    <button type="submit" class="px-2 py-1 bg-red-600 text-white rounded text-sm">Confirm</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">No withdrawals</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $withdrawals->links() }}</div>
</div>
<script>
function showRejectForm(id) {
    document.getElementById('reject-form-' + id).classList.remove('hidden');
}
</script>
@endsection
