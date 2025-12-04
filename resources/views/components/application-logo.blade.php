@props(['class' => 'w-8 h-8'])

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" {{ $attributes->merge(['class' => $class]) }}>
    <defs>
        <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:#3B82F6;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#8B5CF6;stop-opacity:1" />
        </linearGradient>
    </defs>
    <circle cx="50" cy="50" r="45" fill="url(#gradient)" />
    <path d="M35,35 L45,35 L45,65 L35,65 Z M55,35 L65,35 L65,50 L55,50 Z M55,55 L65,55 L65,65 L55,65 Z"
          fill="white" />
    <text x="50" y="85" text-anchor="middle" fill="white" font-size="12" font-weight="bold">B2C</text>
</svg>
