<div class="inline-flex flex-wrap items-center justify-end gap-x-2 gap-y-1 text-xs font-medium text-gray-600 dark:text-gray-300"
     data-live-clock
     aria-label="Current date and time">
    <time data-live-date datetime="{{ now()->toIso8601String() }}">{{ now()->format('D, M j, Y') }}</time>
    <span aria-hidden="true">·</span>
    <time class="tabular-nums" data-live-time datetime="{{ now()->toIso8601String() }}">{{ now()->format('H:i:s') }}</time>
    <span class="text-gray-400 dark:text-gray-500" data-live-timezone>{{ config('app.timezone') }}</span>
</div>