<x-mail::message>
# Balasan Pesan Anda

Halo **{{ $contactMessage->name }}**,

Terima kasih telah menghubungi kami. Berikut adalah balasan dari pesan Anda:

---

**Pesan Anda:**
> {{ $contactMessage->message }}

---

**Balasan dari {{ $repliedBy }}:**

{{ $replyBody }}

---

Jika Anda memiliki pertanyaan lanjutan, silakan hubungi kami kembali melalui halaman kontak di website kami.

Hormat kami,<br>
{{ config('app.name') }}
</x-mail::message>
