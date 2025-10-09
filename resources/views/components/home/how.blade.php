<div
    class="rounded-4xl relative flex grid-rows-[1fr_auto] flex-wrap items-center justify-center gap-x-12 gap-y-8 bg-white px-8 py-12 pt-24 drop-shadow-2xl lg:grid lg:grid-cols-3">

    <div
        class="bg-cedea-gold font-bebas absolute -top-[35%] left-1/2 -translate-x-1/2 translate-y-full rounded-xl px-8 py-4 text-7xl font-bold uppercase italic text-white">
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
        <div class="row-span-2 grid grid-rows-subgrid">
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
