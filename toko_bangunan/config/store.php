<?php
// Nomor WhatsApp resmi Toko Bangunan untuk menerima pesanan pelanggan.
const STORE_WHATSAPP = '6285830395032';
const STORE_WHATSAPP_DISPLAY = '0858-3039-5032';

function whatsapp_order_url(string $product_name, int $quantity, string $customer_name = '', string $customer_address = ''): string
{
    $message = "Halo Toko Bangunan, saya ingin membeli:\n\n";
    $message .= "Produk: {$product_name}\n";
    $message .= "Jumlah: {$quantity}\n";

    if ($customer_name !== '') {
        $message .= "Nama: {$customer_name}\n";
    }
    if ($customer_address !== '') {
        $message .= "Alamat: {$customer_address}\n";
    }

    $message .= "\nMohon info ketersediaan, total harga, dan cara pembayarannya. Terima kasih.";

    return 'https://wa.me/' . STORE_WHATSAPP . '?text=' . rawurlencode($message);
}
