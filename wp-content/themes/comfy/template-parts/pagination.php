<?php
$arrow = '<svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M1.50468 5L10.0547 5" stroke="#283455" stroke-width="1.2381" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M6.64119 0.999999L10.5039 5L6.64119 9" stroke="#283455" stroke-width="1.2381" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
';
the_posts_pagination( array(
    'prev_text' => $arrow,
    'next_text' => $arrow
));