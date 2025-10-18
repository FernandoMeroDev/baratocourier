@props(['title'])

<div class="px-5 max-w-full">
	<div class="grid divide-y mt-8">
		<div class="py-5">
			<details class="group">
				<summary class="flex justify-between items-center font-medium cursor-pointer list-none">
					<span>
                        {{ $title }}
                    </span>
					<span class="transition group-open:rotate-180">
                        <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                    </span>
				</summary>
				<div class="mt-3 group-open:animate-fadeIn">
					{{ $slot }}
				</div>
			</details>
		</div>
	</div>
</div>