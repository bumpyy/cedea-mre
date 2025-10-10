<div class="max-lg:z-[1] max-lg:order-1">
    <div class="clamp-[my,8,16] flex w-full flex-col gap-y-3 lg:w-[120%]">
        <div
            class="rounded-4xl clamp-[px,4,8] clamp-[pb,4,6] clamp-[pt,12,24] relative grid items-center justify-center gap-x-12 gap-y-12 bg-white drop-shadow-2xl md:grid-cols-3 lg:grid-rows-[1fr_auto]">

            <div
                class="bg-cedea-gold font-bebas clamp-[text,3xl,7xl] clamp-[px,4,8] clamp-[py,2,4] absolute -top-[clamp(8%,20vw,15%)] left-1/2 w-max -translate-x-1/2 translate-y-full rounded-xl font-bold uppercase italic text-white lg:-top-[35%]">
                <p>Cara ikutan</p>
            </div>

            @php
                $how_item = [
                    [
                        'image' => 'img/qr.png',
                        'label' => 'Scan',
                        'desc' => 'QR Code di kemasan',
                    ],
                    [
                        'image' => 'img/pc.png',
                        'label' => 'Registration',
                        'desc' => 'Melalui website',
                    ],
                    [
                        'image' => 'img/receipt.png',
                        'label' => 'upload',
                        'desc' => 'Struk asli / foto bukti pembelian',
                    ],
                ];
            @endphp

            @foreach ($how_item as $item)
                <div class="row-span-2 grid md:grid-rows-subgrid">
                    <div class="flex items-center justify-center">
                        <img src="{{ asset($item['image']) }}" alt="">
                    </div>

                    <div class='text-cedea-gold font-bebas flex flex-col items-center justify-start pt-2 text-center'>
                        <p class="text-4xl uppercase">{{ $item['label'] }}</p>
                        <p>{{ $item['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <a class="text-center uppercase" href="#">
            <p class="clamp-[text,lg,xl] inline-flex items-center justify-center font-bold text-white">
                <span>Selengkapnya</span>
                <x-lucide-arrow-right class="size-6" />
            </p>
        </a>
    </div>
</div>
