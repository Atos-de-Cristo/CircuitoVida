@props(['size' => 'h-5 w-5', 'color' => 'fill-current text-gray-400 '])

<svg {{ $attributes->merge(['class' => $size]) }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
    fill="currentColor">
    <path {{ $attributes->merge(['class' => $color]) }}
        d="M11 2a1 1 0 01.993.883L12 3v4h4a1 1 0 01.117 1.993L16 9h-4v4a1 1 0 01-1.993.117L10 13V9H6a1 1 0 01-.117-1.993L6 7h4V3a1 1 0 011-1z"
        clip-rule="evenodd" />
</svg>
