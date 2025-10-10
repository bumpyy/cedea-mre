<di>
    <div
        class="rounded-4xl relative grid items-center justify-center gap-x-12 gap-y-12 bg-white px-8 py-12 pt-24 drop-shadow-2xl md:grid-cols-3 lg:grid-rows-[1fr_auto]">

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
                <div class='text-cedea-gold font-bebas flex flex-col items-center justify-start text-center'>
                    <p class="text-4xl uppercase">{{ $item['label'] }}</p>
                    <p>{{ $item['desc'] }}</p>
                </div>
            </div>
        @endforeach

    </div>
    <a class="flex items-center justify-center uppercase text-white" href="#">
        <span>Selengkapnya</span>
        <x-lucide-arrow-right class="w-3" />
    </a>
</di>
