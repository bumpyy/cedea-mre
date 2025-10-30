 <div class="flex flex-col gap-6">
     <x-auth-header title="Lupa Kata Sandi"
         description="Masukkan alamat email Anda untuk menerima tautan kata sandi yang baru" />

     <!-- Session Status -->
     <x-auth-session-status class="text-center" :status="session('status')" />

     <form class="flex flex-col gap-6" method="POST" wire:submit="sendPasswordResetLink">
         <!-- Email Address -->
         <flux:field>
             <flux:label class="text-white">E-mail</flux:label>
             <flux:input class="text-black" name="email" type="email" wire:model="email" required autocomplete="email"
                 placeholder="email@example.com" />
             <flux:error class="" name="email" />
         </flux:field>


         <flux:button class="w-full" variant="primary" type="submit">Kirim tautan kata sandi yang baru</flux:button>
     </form>

     <div class="space-x-1 text-center text-sm text-zinc-400 rtl:space-x-reverse">
         <span>Atau, kembali ke</span>
         <flux:link class="text-white" :href="route('login')">log in</flux:link>
     </div>
 </div>
