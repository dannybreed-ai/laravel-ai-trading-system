@extends('layouts.app')
@section('title', 'Manage KYC')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-8">KYC Submissions</h1>
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Document Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Submitted</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($kycRecords as $kyc)
                    <tr>
                        <td class="px-6 py-4 text-sm">{{ $kyc->user->name }}</td>
                        <td class="px-6 py-4 text-sm">{{ ucfirst(str_replace('_', ' ', $kyc->document_type)) }}</td>
                        <td class="px-6 py-4"><span class="px-2 text-xs rounded-full {{ $kyc->status === 'approved' ? 'bg-green-100 text-green-800' : ($kyc->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">{{ ucfirst($kyc->status) }}</span></td>
                        <td class="px-6 py-4 text-sm">{{ $kyc->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('admin.kyc.review', $kyc) }}" class="text-primary hover:underline">Review</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">No KYC submissions</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $kycRecords->links() }}</div>
</div>
@endsection
