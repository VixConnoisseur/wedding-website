// Enhanced scroll reveal, sticky navbar, smooth scroll, mobile menu toggle, countdown, custom cursor, music player, RSVP confirmation timer, personalized message

document.addEventListener("DOMContentLoaded", function () {
  // Scroll reveal for sections and schedule cards
  const els = document.querySelectorAll("section, .schedule-card");
  const io = new IntersectionObserver(
    (entries) => {
      entries.forEach((e) => {
        if (e.isIntersecting) {
          e.target.classList.add("opacity-100", "translate-y-0");
        }
      });
    },
    { threshold: 0.15 }
  );
  els.forEach((s) => {
    s.classList.add("opacity-0", "translate-y-6", "transition", "duration-700");
    io.observe(s);
  });

  // Sticky navbar with background and shadow on scroll
  const navbar = document.getElementById("navbar");
  window.addEventListener("scroll", () => {
    if (window.scrollY > 20) {
      navbar.classList.add("scrolled");
    } else {
      navbar.classList.remove("scrolled");
    }
  });

  // Smooth scroll for anchor links (desktop and mobile)
  document.querySelectorAll('nav a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute("href"));
      if (target) {
        target.scrollIntoView({ behavior: "smooth", block: "start" });
      }
      // Close mobile menu on link click (if open)
      if (window.innerWidth < 768) {
        menuBtn.classList.remove("open");
        mobileMenu.classList.remove("open");
        mobileMenu.style.maxHeight = null;
        menuBtn.setAttribute("aria-expanded", "false");
      }
    });
  });

  // Mobile menu toggle
  const menuBtn = document.getElementById("menu-btn");
  const mobileMenu = document.getElementById("mobile-menu");

  menuBtn.addEventListener("click", () => {
    const expanded = menuBtn.getAttribute("aria-expanded") === "true" || false;
    menuBtn.setAttribute("aria-expanded", !expanded);
    menuBtn.classList.toggle("open");
    mobileMenu.classList.toggle("open");
    if (mobileMenu.classList.contains("open")) {
      mobileMenu.style.maxHeight = mobileMenu.scrollHeight + "px";
    } else {
      mobileMenu.style.maxHeight = null;
    }
  });

  // Custom cursor
  const cursor = document.getElementById("custom-cursor");
  window.addEventListener("mousemove", (e) => {
    cursor.style.left = e.clientX + "px";
    cursor.style.top = e.clientY + "px";
  });

  // Countdown Timer to wedding date
  const countdownEl = document.getElementById("countdown");
  const weddingDate = new Date("February 17, 2026 00:00:00").getTime();

  function updateCountdown() {
    const now = new Date().getTime();
    const distance = weddingDate - now;

    if (distance < 0) {
      countdownEl.textContent = "The wedding day has arrived!";
      return;
    }

    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor(
      (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
    );
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

    countdownEl.textContent = `Countdown: ${days}d ${hours}h ${minutes}m ${seconds}s`;
  }
  updateCountdown();
  setInterval(updateCountdown, 1000);

  // Music Player controls
  const music = document.getElementById("wedding-music");
  const musicToggle = document.getElementById("music-toggle");

  musicToggle.addEventListener("click", () => {
    if (music.paused) {
      music.play();
      musicToggle.textContent = "Pause";
      musicToggle.setAttribute("aria-pressed", "true");
      musicToggle.setAttribute("aria-label", "Pause music");
    } else {
      music.pause();
      musicToggle.textContent = "Play";
      musicToggle.setAttribute("aria-pressed", "false");
      musicToggle.setAttribute("aria-label", "Play music");
    }
  });

  // Personalized welcome message and RSVP confirmation timer
  const welcomeMessageEl = document.getElementById("welcome-message");
  const rsvpConfirmationEl = document.getElementById("rsvp-confirmation");
  const confirmationTimerEl = document.getElementById("confirmation-timer");

  // Check if user RSVP'd (simulate with localStorage for demo)
  function showWelcomeMessage(name) {
    welcomeMessageEl.textContent = `Welcome back, ${name}! Thank you for RSVPing.`;
    welcomeMessageEl.style.display = "block";
  }

  function startConfirmationTimer(seconds) {
    rsvpConfirmationEl.style.display = "block";
    let timeLeft = seconds;
    confirmationTimerEl.textContent = `This message will disappear in ${timeLeft} seconds.`;

    const interval = setInterval(() => {
      timeLeft--;
      if (timeLeft <= 0) {
        rsvpConfirmationEl.style.display = "none";
        clearInterval(interval);
      } else {
        confirmationTimerEl.textContent = `This message will disappear in ${timeLeft} seconds.`;
      }
    }, 1000);
  }

  // Simulate RSVP form submission success by checking localStorage
  // In real app, you would check server response or session
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get("rsvp") === "success") {
    // Assume name is passed as param for demo
    const name = urlParams.get("name") || "Guest";
    showWelcomeMessage(name);
    startConfirmationTimer(15);
  } else {
    // If user previously RSVPed, show welcome message
    const savedName = localStorage.getItem("rsvpName");
    if (savedName) {
      showWelcomeMessage(savedName);
    }
  }

  // Save RSVP name on form submit (for demo)
  const rsvpForm = document.querySelector("#rsvp form");
  if (rsvpForm) {
    rsvpForm.addEventListener("submit", (e) => {
      const formData = new FormData(rsvpForm);
      const name = formData.get("name");
      if (name) {
        localStorage.setItem("rsvpName", name);
      }
    });
  }
});
