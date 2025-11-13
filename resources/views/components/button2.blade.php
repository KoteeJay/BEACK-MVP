@props(['href' => '#', 'type' => 'primary'])


<a  href="{{ $href }} {{ $type === 'primary' 
        ? 'bg-blue-600 hover:bg-blue-500 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-200 ease-in-out' 
        : 'border-2 border-blue-600 text-blue-600 font-semibold px-6 py-3 rounded-lg inline-block hover:bg-blue-600 hover:text-white active:bg-blue-700 active:border-blue-700 transition duration-200 ease-in-out' }}">

                      {{ $slot }}                     
       
</a>