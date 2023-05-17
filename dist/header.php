<?php

// <!-- header -->
function head($title)
{
    date_default_timezone_set('Asia/Kathmandu');
    echo '<div>
    <div class="bg-[#1E1E1E] h-14 grid grid-cols-12 px-6 text-center border-b shadow-md">
        <div class="col-span-10 flex justify-center items-center h-full">
            <p class="text-[#F1F5F9] font-bold">Pharmacy Management System</p>
        </div>
        <div class="col-span-2 flex flex-col  items-end justify-center">
        <div id="current-time" class="text-[#F1F5F9] font-bold text-xl flex items-baseline gap-1">
                <p id="time" class="inline-block"></p>
                <p id="seconds" class="inline-block text-xs font-thin w-3"></p>
                <p id="am-pm" class="inline-block text-[#F1F5F9] font-bold text-lg"></p>
            </div>
        <p class="text-[#F1F5F9] font-semibold text-xs">' . date('F j, Y') . '</p>
        </div>
        </div>
    </div>';
}
?>

  
