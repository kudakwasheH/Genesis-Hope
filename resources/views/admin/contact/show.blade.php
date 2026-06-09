@extends('layouts.admin')

@section('content')
<div class="space-y-8 max-w-3xl mx-auto">
    
    <!-- Back Header -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('admin.contact.index') }}" class="px-3 py-2 rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-xs font-bold transition-all">
            &larr; Back to Inbox
        </a>
    </div>

    <!-- Message Details Card -->
    <div class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-3xl p-8 sm:p-12 shadow-sm space-y-6">
        <div class="border-b border-slate-50 dark:border-slate-700 pb-4">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Inquiry Subject</span>
            <h2 class="text-2xl font-black text-slate-900 dark:text-white mt-1">{{ $message->subject }}</h2>
        </div>

        <!-- Sender Info Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm bg-slate-50 dark:bg-slate-900 p-6 rounded-2xl border border-slate-100 dark:border-slate-800">
            <p><strong>From:</strong> {{ $message->name }}</p>
            <p><strong>Email Address:</strong> {{ $message->email }}</p>
            <p><strong>Contact Phone:</strong> {{ $message->phone ?? 'Not provided' }}</p>
            <p><strong>Date Received:</strong> {{ $message->created_at->format('l, F j, Y \a\t H:i') }}</p>
        </div>

        <!-- Message Body -->
        <div class="space-y-2">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Message Content</h4>
            <div class="text-slate-650 dark:text-slate-350 leading-relaxed text-sm sm:text-base border border-slate-150 rounded-2xl p-6 whitespace-pre-wrap">
                {{ $message->message }}
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-between items-center pt-6 border-t border-slate-50 dark:border-slate-700">
            <form action="{{ route('admin.contact.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Delete message permanently?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-5 py-2.5 rounded-full bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition-all shadow-sm">
                    Delete Inquiry
                </button>
            </form>
            
            <a href="mailto:{{ $message->email }}?subject=Re:%20{{ $message->subject }}" class="px-6 py-3 rounded-full bg-slate-900 hover:bg-teal-600 hover:text-white text-white font-bold transition-all text-xs">
                Reply via Email
            </a>
        </div>
    </div>
</div>
@endsection
