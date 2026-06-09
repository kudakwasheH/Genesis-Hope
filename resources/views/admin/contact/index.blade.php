@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    
    <!-- Heading -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-3xl font-black text-slate-900 dark:text-white">Contact Inbox</h1>
            <p class="text-slate-400 text-sm mt-0.5">View and read general inquiries sent from the public website.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-250 text-emerald-800 rounded-2xl p-4 text-sm font-semibold flex items-center space-x-3 shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Inbox Table -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-100 dark:border-slate-700 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 dark:divide-slate-700 text-left text-sm text-slate-500 dark:text-slate-400">
                <thead class="bg-slate-50 dark:bg-slate-900 text-xs text-slate-700 dark:text-slate-300 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Sender</th>
                        <th class="px-6 py-4">Subject</th>
                        <th class="px-6 py-4">Received Date</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors {{ !$msg->is_read ? 'font-semibold bg-teal-500/5 dark:bg-teal-950/10' : '' }}">
                            <td class="px-6 py-4">
                                <div class="text-slate-900 dark:text-white">{{ $msg->name }}</div>
                                <div class="text-slate-400 text-xs mt-0.5">{{ $msg->email }} | {{ $msg->phone ?? 'No phone' }}</div>
                            </td>
                            <td class="px-6 py-4 text-slate-800 dark:text-slate-200 truncate max-w-xs">{{ $msg->subject }}</td>
                            <td class="px-6 py-4">{{ $msg->created_at->format('M d, Y H:i') }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold border capitalize 
                                    {{ $msg->is_read ? 'bg-slate-100 text-slate-500 border-slate-200' : 'bg-teal-50 text-teal-700 border-teal-150' }}">
                                    {{ $msg->is_read ? 'Read' : 'Unread' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 shrink-0">
                                <a href="{{ route('admin.contact.show', $msg->id) }}" class="text-teal-650 hover:underline font-bold text-xs">Read</a>
                                
                                <form action="{{ route('admin.contact.toggle-read', $msg->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-slate-500 hover:underline text-xs">Mark {{ $msg->is_read ? 'Unread' : 'Read' }}</button>
                                </form>
                                
                                <form action="{{ route('admin.contact.destroy', $msg->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete message permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:underline text-xs">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">No inbox messages.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($messages->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
