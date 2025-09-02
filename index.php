<?php
include 'db.php';
?>
<!doctype html>
<html lang="en" >
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Arvin & Jennifer — Wedding</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Great+Vibes&family=Inter:wght@300;400;600&display=swap">
  <style>
    :root {
      --deep-red: #8B0000;
      --beige: #F3ECE6;
    }

    .serif {
      font-family: 'Playfair Display', serif;
      letter-spacing: 0.03em;
    }
    .script {
      font-family: 'Great Vibes', cursive;
      letter-spacing: 0.05em;
    }

    .hero-overlay {
      background: linear-gradient(180deg, rgba(139,0,0,0.6), rgba(0,0,0,0.2));
      backdrop-filter: brightness(0.85);
    }

    nav {
      transition: background-color 0.5s ease, box-shadow 0.5s ease;
      z-index: 50;
    }
    #navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background-color: var(--beige);
      backdrop-filter: saturate(180%) blur(10px);
    }
    #navbar.scrolled {
      background-color: rgba(255 255 255 / 0.95);
      box-shadow: 0 2px 12px rgb(0 0 0 / 0.1);
    }

    .nav-link {
      position: relative;
      padding-bottom: 2px;
      transition: color 0.3s ease;
    }
    .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: 0;
      left: 0;
      background-color: var(--deep-red);
      transition: width 0.3s ease;
    }
    .nav-link:hover::after,
    .nav-link:focus::after {
      width: 100%;
    }

    #menu-btn.open span:nth-child(1) {
      transform: rotate(45deg) translate(5px, 5px);
    }
    #menu-btn.open span:nth-child(2) {
      opacity: 0;
    }
    #menu-btn.open span:nth-child(3) {
      transform: rotate(-45deg) translate(5px, -5px);
    }

    #mobile-menu {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease;
    }
    #mobile-menu.open {
      max-height: 500px;
    }

    input:focus, select:focus, textarea:focus {
      outline: none;
      border-color: var(--deep-red);
      box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.3);
      transition: box-shadow 0.3s ease, border-color 0.3s ease;
    }

    button:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 12px rgba(139, 0, 0, 0.4);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .opacity-0 {
      opacity: 0;
      transform: translateY(1.5rem);
      transition: opacity 0.7s ease, transform 0.7s ease;
    }
    .opacity-100 {
      opacity: 1;
      transform: translateY(0);
    }

    /* Parallax background */
    header#home {
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-position: center center;
      background-size: cover;
      position: relative;
      overflow: hidden;
    }

    /* Custom cursor */
    #custom-cursor {
      position: fixed;
      top: 0; left: 0;
      width: 20px; height: 20px;
      border: 2px solid var(--deep-red);
      border-radius: 50%;
      pointer-events: none;
      transform: translate(-50%, -50%);
      transition: transform 0.15s ease, background-color 0.3s ease, opacity 0.3s ease;
      z-index: 9999;
      mix-blend-mode: difference;
      opacity: 0.8;
    }
    a:hover ~ #custom-cursor,
    button:hover ~ #custom-cursor,
    input:hover ~ #custom-cursor,
    select:hover ~ #custom-cursor,
    textarea:hover ~ #custom-cursor {
      transform: translate(-50%, -50%) scale(1.5);
      background-color: var(--deep-red);
      opacity: 1;
    }

    @media (max-width: 640px) {
      h1.script {
        font-size: 3.5rem !important;
      }
    }

    #gallery img:hover {
      filter: brightness(1.1);
      transition: filter 0.3s ease;
    }

    #schedule {
      background: linear-gradient(135deg, #f9f5f2 0%, #f3ece6 100%);
    }

    .schedule-card {
      background: rgba(255 255 255 / 0.75);
      backdrop-filter: saturate(180%) blur(12px);
      border-radius: 1rem;
      box-shadow: 0 8px 24px rgb(139 0 0 / 0.15);
      padding: 1.5rem;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: default;
      user-select: none;
    }
    .schedule-card:hover, .schedule-card:focus-within {
      transform: scale(1.05);
      box-shadow: 0 12px 32px rgb(139 0 0 / 0.3);
      outline: none;
    }
    .schedule-card h3, .schedule-card p {
      text-align: center;
    }

    /* Countdown styles */
    #countdown {
      font-family: 'Inter', sans-serif;
      font-weight: 600;
      font-size: 1.25rem;
      color: white;
      margin-top: 1rem;
      letter-spacing: 0.05em;
      user-select: none;
    }

    /* RSVP Confirmation Timer */
    #rsvp-confirmation {
      margin-top: 1rem;
      font-weight: 600;
      color: var(--deep-red);
    }

    /* Music Player */
    #music-player {
      position: fixed;
      bottom: 20px;
      right: 20px;
      background: rgba(255 255 255 / 0.85);
      backdrop-filter: saturate(180%) blur(12px);
      border-radius: 9999px;
      box-shadow: 0 4px 12px rgb(139 0 0 / 0.3);
      padding: 0.5rem 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      z-index: 10000;
    }
    #music-player button {
      background: var(--deep-red);
      border: none;
      color: white;
      padding: 0.3rem 0.6rem;
      border-radius: 9999px;
      cursor: pointer;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }
    #music-player button:hover {
      background-color: #5a0000;
    }

    /* Map container */
    #map {
      width: 100%;
      height: 300px;
      border-radius: 1rem;
      box-shadow: 0 8px 24px rgb(139 0 0 / 0.15);
      margin-top: 1rem;
    }

    /* Personalized welcome message */
    #welcome-message {
      margin-bottom: 1rem;
      font-size: 1.25rem;
      font-weight: 600;
      color: var(--deep-red);
    }
  </style>
</head>
<body class="bg-white text-gray-900 antialiased relative" aria-label="Wedding website of Arvin and Jennifer">

<!-- Custom Cursor -->
<div id="custom-cursor" aria-hidden="true"></div>

<!-- Navbar -->
<nav id="navbar" role="navigation" aria-label="Primary Navigation">
  <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-center md:justify-between">
    <div class="text-lg font-semibold serif text-[var(--deep-red)] select-none text-center md:text-left" tabindex="0">Arvin & Jennifer</div>
    <div class="hidden md:flex gap-6 uppercase text-sm font-medium text-[var(--deep-red)] justify-center">
      <a href="#home" class="nav-link" role="link">Home</a>
      <a href="#schedule" class="nav-link" role="link">Schedule</a>
      <a href="#story" class="nav-link" role="link">Our Story</a>
      <a href="#rsvp" class="nav-link" role="link">RSVP</a>
      <a href="#gallery" class="nav-link" role="link">Photos</a>
      <a href="login.php" class="px-4 py-1 rounded-md bg-[var(--deep-red)] text-white font-semibold shadow hover:scale-105 transition" role="link">Admin</a>
    </div>
    <button id="menu-btn" class="md:hidden flex flex-col justify-center items-center w-8 h-8 gap-1" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobile-menu">
      <span class="block w-6 h-0.5 bg-[var(--deep-red)]"></span>
      <span class="block w-6 h-0.5 bg-[var(--deep-red)]"></span>
      <span class="block w-6 h-0.5 bg-[var(--deep-red)]"></span>
    </button>
  </div>
  <div id="mobile-menu" class="hidden md:hidden bg-white shadow-lg border-t border-gray-200 text-center" role="menu" aria-label="Mobile Navigation Menu">
    <a href="#home" class="block px-6 py-3 border-b" role="menuitem">Home</a>
    <a href="#schedule" class="block px-6 py-3 border-b" role="menuitem">Schedule</a>
    <a href="#story" class="block px-6 py-3 border-b" role="menuitem">Our Story</a>
    <a href="#rsvp" class="block px-6 py-3 border-b" role="menuitem">RSVP</a>
    <a href="#gallery" class="block px-6 py-3 border-b" role="menuitem">Photos</a>
    <a href="login.php" class="block px-6 py-3 text-white bg-[var(--deep-red)] font-semibold" role="menuitem">Admin</a>
  </div>
</nav>

<!-- Header with Parallax Background and Countdown -->
<header id="home" class="relative h-screen flex flex-col items-center justify-center text-center overflow-hidden px-6" 
  style="background-image: url('images/floralbg.jpg'), url('images/hero-new.png'); background-size: cover, cover; background-position: center, center;" role="banner" aria-label="Wedding invitation header with couple's names and date">

  <div class="absolute inset-0 hero-overlay"></div>

  <!-- Red Glass Container -->
  <div class="relative z-20 max-w-3xl p-10 rounded-2xl shadow-xl 
              bg-gradient-to-br from-[rgba(139,0,0,0.55)] to-[rgba(255,255,255,0.15)]
              backdrop-blur-md border border-[rgba(255,255,255,0.25)] text-white">
    <h1 class="script text-6xl md:text-8xl font-bold drop-shadow-lg select-none" tabindex="0">Arvin &amp; Jennifer</h1>
    <p class="mt-4 text-lg md:text-xl drop-shadow-md" tabindex="0">We invite you to celebrate with us</p>
    <p class="mt-2 italic drop-shadow-md" tabindex="0">February 17, 2026 • 00:00 PM</p>
    <a href="#rsvp" 
       class="mt-6 inline-block bg-white text-[var(--deep-red)] px-6 py-3 rounded-full font-semibold shadow hover:scale-105 transition" role="button" aria-label="RSVP Now Button">
       RSVP Now
    </a>
    <div id="countdown" aria-live="polite" aria-atomic="true" aria-label="Countdown to wedding date"></div>
  </div>
</header>

<main class="flex flex-col items-center" role="main">

  <section id="schedule" class="py-20 relative z-10 w-full max-w-5x2 px-6 text-center" aria-labelledby="schedule-title">
    <h2 id="schedule-title" class="text-3xl serif text-[var(--deep-red)] font-bold mb-12">Schedule</h2>
    <div class="grid md:grid-cols-3 gap-8">
      <article class="schedule-card" tabindex="0" aria-label="Preparation schedule">
        <h3 class="font-semibold text-xl mb-2">Preparation</h3>
        <p class="text-sm text-gray-600 mb-3">Sunday • February 16 • 00:00 PM</p>
        <p class="text-gray-700">An exciting opportunity to relax and prepare for the big day.</p>
      </article>
      <article class="schedule-card" tabindex="0" aria-label="Ceremony schedule">
        <h3 class="font-semibold text-xl mb-2">Ceremony</h3>
        <p class="text-sm text-gray-600 mb-3">Monday • February 17 • 00:00 PM</p>
        <p class="text-gray-700">Locale of Ciudad De Victoria, Bocaue, Bulacan</p>
      </article>
      <article class="schedule-card" tabindex="0" aria-label="Reception schedule">
        <h3 class="font-semibold text-xl mb-2">Reception</h3>
        <p class="text-sm text-gray-600 mb-3">Monday • February 17 • 00:00 PM</p>
        <p class="text-gray-700">Di ko pa alam kung saan pero bawal gate crasher</p>
      </article>
    </div>
  </section>

  <section id="story" class="py-40 relative z-10 w-full max-w-3xl px-6 text-center" aria-labelledby="story-title">
    <h2 id="story-title" class="text-3xl serif text-[var(--deep-red)] font-bold mb-4">Our Love Story</h2>
    <p class="text-gray-700 max-w-xl mx-auto" tabindex="0">Arvin and Jennifer met ay aywan ko ba dili ko alam kung paano sila nagkakilala ay</p>
  </section>

  <section id="gallery" class="py-16 bg-gray-50 relative z-10 w-full max-w-5xl px-6 text-center" aria-labelledby="gallery-title">
    <h2 id="gallery-title" class="text-3xl serif text-[var(--deep-red)] font-bold mb-8">Photos</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
      <img src="images/pic1.jpg" alt="Wedding photo 1" class="w-full h-48 object-cover rounded-lg shadow hover:scale-105 transition" loading="lazy" />
      <img src="images/pic2.jpg" alt="Wedding photo 2" class="w-full h-48 object-cover rounded-lg shadow hover:scale-105 transition" loading="lazy" />
      <img src="images/pic3.jpg" alt="Wedding photo 3" class="w-full h-48 object-cover rounded-lg shadow hover:scale-105 transition" loading="lazy" />
      <img src="images/pic4.jpg" alt="Wedding photo 4" class="w-full h-48 object-cover rounded-lg shadow hover:scale-105 transition" loading="lazy" />
    </div>
  </section>
    <section id="rsvp" class="py-16 relative z-10 w-full max-w-lg px-6 text-center" aria-labelledby="rsvp-title">
    <h2 id="rsvp-title" class="text-3xl serif text-[var(--deep-red)] font-bold mb-4">RSVP</h2>

    <div id="welcome-message" role="alert" aria-live="polite" style="display:none;"></div>

    <form action="rsvp.php" method="POST" class="bg-white p-6 rounded-xl shadow space-y-4 text-left" role="form" aria-describedby="rsvp-desc">
      <p id="rsvp-desc" class="sr-only">Please fill out the form to RSVP for the wedding.</p>
      <div>
        <label for="name" class="block text-sm font-medium">Full name</label>
        <input id="name" name="name" required aria-required="true" class="mt-1 p-3 border rounded w-full" placeholder="Your full name" />
      </div>
      <div>
        <label for="email" class="block text-sm font-medium">Email</label>
        <input id="email" name="email" type="email" required aria-required="true" class="mt-1 p-3 border rounded w-full" placeholder="you@example.com" />
      </div>
      <div class="flex gap-4 justify-center">
        <select name="attendance" required aria-required="true" class="p-3 border rounded w-full max-w-xs" aria-label="Will you attend?">
          <option value="">-- Will you attend? --</option>
          <option value="Yes">Yes, I will attend</option>
          <option value="No">No, I can't make it</option>
        </select>
        <input name="guests" type="number" min="1" value="1" aria-label="Number of guests" class="p-3 border rounded w-28" placeholder="Guests" />
      </div>
      <div>
        <label for="message" class="block text-sm font-medium">Message / Dietary</label>
        <textarea id="message" name="message" class="mt-1 p-3 border rounded w-full" rows="3" placeholder="Any notes..."></textarea>
      </div>
      <div class="text-center">
        <button type="submit" class="bg-[var(--deep-red)] text-white px-6 py-3 rounded-full font-semibold hover:scale-105 transition" aria-label="Send RSVP">Send RSVP</button>
      </div>
    </form>

    <div id="rsvp-confirmation" aria-live="polite" aria-atomic="true" style="display:none;">
      Thank you for your RSVP! You can update your response anytime.
      <br />
      <span id="confirmation-timer"></span>
    </div>
  </section>

  <section id="map-section" class="py-16 relative z-10 w-full max-w-5xl px-6 text-center" aria-labelledby="map-title">
    <h2 id="map-title" class="text-3xl serif text-[var(--deep-red)] font-bold mb-4">Venue Location</h2>
    <div id="map" role="region" aria-label="Map showing wedding venue location">
      <iframe 
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3857.5347980887946!2d120.94660707362638!3d14.795213472285358!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397ad9743d39081%3A0xe9b817c585bdcb8f!2sIglesia%20Ni%20Cristo%20-%20Lokal%20ng%20Ciudad%20De%20Victoria%20%5BBulacan%20South%5D!5e0!3m2!1sen!2sph!4v1756823981473!5m2!1sen!2sph"
        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" aria-hidden="false" tabindex="0"></iframe>
    </div>
  </section>

</main>

<!-- Music Player -->
<div id="music-player" role="region" aria-label="Background music player">
  <audio id="wedding-music" src="music/wedding-song.mp3" preload="auto" loop></audio>
  <button id="music-toggle" aria-pressed="false" aria-label="Play music">Play</button>
</div>

<footer class="py-8 bg-[var(--deep-red)] text-white text-center relative z-10" role="contentinfo">
  <p class="max-w-2xl mx-auto px-6">Credits to Michael Jacob Baleyos Guasis from BLK 120 LOT 21 VILLA ZARAGOSA &amp; CONTACT #: +63 9694059828</p>
</footer>

<script src="script.js"></script>
</body>
</html>


