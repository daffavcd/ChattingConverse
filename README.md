# Chat App (Real-time using Pusher)
Here i'm trying to do a demostrate using 2 user (Daffa Athallah & Rheia Toteris)

## Landing page (Login)
<img src="/image_read/1.jpeg" title="Screenshot 1"/>

## Home page
<img src="/image_read/2.jpeg" title="Screenshot 2"/>

## If you click your contact
<img src="/image_read/3.jpeg" title="Screenshot 3"/>

## Try to send any chat to Rheia
<img src="/image_read/4.jpeg" title="Screenshot 4"/>

## Rheia page when the message already sent
<img src="/image_read/5.jpeg" title="Screenshot 5"/>

## Rheia opening daffa's message
<img src="/image_read/6.jpeg" title="Screenshot 6"/>

## Rheia sending chat to daffa
<img src="/image_read/7.jpeg" title="Screenshot 7"/>

## Daffa opening rheia's answer 
<img src="/image_read/8.jpeg" title="Screenshot 8"/>

## Daffa sending image file to rheia
<img src="/image_read/9.jpeg" title="Screenshot 9"/>

## Rheia viewing image from daffa
<img src="/image_read/10.jpeg" title="Screenshot 10"/>

## You can click the image for zooming in
<img src="/image_read/11.jpeg" title="Screenshot 11"/>

## Chat App (Real-time using Pusher)

This Project is for my thesis during Advance Web Programming Class,

You can leave a comment or ask for contributor if you want to help me grow. Thanks 

This project is real-time chatting app using Pusher with Jquery, i'm using template for this project but i'm really sorry i couldn't remember the link and the creator.

<p align="center"><a href="https://thesatanictemple.com/" target="_blank"><img src="https://image.freepik.com/free-vector/baphomet-cute-kawaii_60223-36.jpg" width="300" ></a></p>

# REPORT BUG HERE(AS FAR AS WE KNOW)
```bash
dont forget to delete this list when its already done.
```
## NOTE FRONTEND
- Jika pada chat nama file terlalu panjang maka tampilannya glitch
- Image Preview saat height terlalu panjang maka tampilan glitch (tidak bisa scroll)
- Tampilan warna biru mungkin perlu diperbaiki
- Belum ada loading / skeleton css sebelum up
- Background chat ganti (noodle art or else)
- Tampilan kanan masih polos saat habis login(belum klik contact)
- Cek unread messages css (ganti warna,css div="unread" tidak mau full sampai ke kanan kehalang scroll)
## NOTE BACKEND
- Buka contact scroll tidak langsung ke bawah karena image belum terload(gunakan skeleton)
- Chat shows 10 limit only => scroll ke atas untuk load old chat? 
- Suara notif saat chat masuk & saat terima chat dari contact yang diklik
- Image dowload dulu sebelum bisa di lihat?
- Gunakan cache
- Saat recipient dan from sama text not read auto readed karena saat terima pusher langsung masuk fungsi update
- Encrypt message?
- Bug dalam penamaan user minim harus 2 atau 3 tidak bisa 1
- Contact Belum tampil berdasarkan desc messege terbaru
- Message belum tampil sebelum user menambah contact kedua2 nya 
```bash
Logika message: contact harus tampil secara desc berdasarkan message terbaru,walaupun recipient belum menambah contact dan sender mengirim pesan ke recipient, pesan harus sudah tampil
```
## HAVENT DONE WHATSOEVER
- Contact (selama ini langsung connect ke tabel users)
- Group chat
- Profile
- Typing status
- Setting*
- Online or Not || Status => away,busy (choose one maybe)?
- Logout
- ...
### SPECIAL CHARACTER
- *  = Optional need much time.
- ?  = Still discussed, because so many method available.
- || = OR option.
- => = Current method that gonna be used.

# LONG LIVE THE MONARCH !!!