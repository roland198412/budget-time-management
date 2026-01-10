<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" {{ $attributes }}>
    <!-- Clock face background -->
    <circle cx="50" cy="50" r="45" fill="currentColor" opacity="0.1"/>

    <!-- Clock border -->
    <circle cx="50" cy="50" r="40" fill="none" stroke="currentColor" stroke-width="4"/>

    <!-- Hour markers -->
    <circle cx="50" cy="14" r="3" fill="currentColor"/>
    <circle cx="86" cy="50" r="3" fill="currentColor"/>
    <circle cx="50" cy="86" r="3" fill="currentColor"/>
    <circle cx="14" cy="50" r="3" fill="currentColor"/>

    <!-- Clock hands (10:10 position) -->
    <line x1="50" y1="50" x2="50" y2="26" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
    <line x1="50" y1="50" x2="70" y2="35" stroke="currentColor" stroke-width="3.5" stroke-linecap="round"/>

    <!-- Center dot -->
    <circle cx="50" cy="50" r="4" fill="currentColor"/>

    <!-- Dollar sign badge -->
    <g opacity="0.9">
        <circle cx="75" cy="25" r="18" fill="currentColor"/>
        <path d="M 75 13 L 75 37" stroke="white" stroke-width="3" stroke-linecap="round"/>
        <path d="M 68 19 C 68 19 68 16 75 16 C 82 16 82 19 82 19 C 82 19 82 22 75 22 C 68 22 68 25 68 25 C 68 25 68 28 75 28 C 82 28 82 25 82 25" stroke="white" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
    </g>
</svg>
