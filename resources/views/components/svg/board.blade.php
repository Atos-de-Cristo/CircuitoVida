@props(['size' => 'h-5 w-5', 'color' => 'fill-current text-slate-600 dark:text-slate-200'])
<svg {{ $attributes->merge(['class' => $size]) }} version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg"
      xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" stroke="#000000"
      stroke-width="0.00512">
      <path {{ $attributes->merge(['class' => $size]) }}
          d="M512,0H0v40h16v296h480V40h16V0z M464,304H48V40h416V304z"></path>

      <polygon {{ $attributes->merge(['class' => $size]) }}
          points="113.273,512 145.273,512 212.179,352 180.179,352 "></polygon>
      <polygon {{ $attributes->merge(['class' => $size]) }}
          points="299.82,352 366.726,512 398.726,512 331.82,352 "></polygon>
  </svg>
