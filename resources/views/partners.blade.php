<section class="clients">
  <div class="clients__title">
    <h2 class="title"> clientes</h2>
  </div>
  <div class="clients__slider">
    <ul class="clients__list" id="clients-list">
      <!-- Populated dynamically -->
    </ul>
  </div>
</section>

<style>
  .clients {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .clients__title {
    padding: 0.5rem 0;
    border-bottom: 1px solid #ccc5b9;
    position: relative;
    text-align: center;
  }

  .clients__title::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    width: 250px;
    margin: 0 auto;
    background-color: #eb5e28;
  }

  .clients__slider {
    height: 180px;
    overflow: hidden;
    mask-image: linear-gradient(to right, transparent, #000 10%, #000 90%, transparent);
    position: relative;
    touch-action: pan-y; /* allow vertical scroll */
  }

  .clients__list {
    display: flex;
    gap: 2rem;
    align-items: center;
    animation: scroll-left var(--scroll-duration, 30s) linear infinite;
    animation-play-state: running;
    cursor: grab;
    user-select: none;
  }

  /* Pause animation on hover */
  .clients__slider:hover .clients__list,
  .clients__list.dragging {
    animation-play-state: paused;
    cursor: grabbing;
  }

  .clients__list li {
    flex: 0 0 auto;
    height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .clients__list img {
    max-height: 100%;
    max-width: 150px;
    object-fit: contain;
    pointer-events: none; /* prevent drag selecting image */
  }

  @keyframes scroll-left {
    0% {
      transform: translateX(0);
    }
    100% {
      transform: translateX(-50%);
    }
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .clients__list img {
      max-width: 100px;
    }
    .clients__slider {
      height: 120px;
    }
    /* Speed up on smaller devices */
    :root {
      --scroll-duration: 20s;
    }
  }

  @media (max-width: 480px) {
    .clients__list img {
      max-width: 80px;
    }
    .clients__slider {
      height: 100px;
    }
    :root {
      --scroll-duration: 15s;
    }
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const basePath = 'https://sfi.farwell-consultants.com/storage/uploads/';
    const list = document.getElementById('clients-list');
    let isDragging = false;
    let startX;
    let scrollLeft;

    fetch('https://sfi.farwell-consultants.com/api/partners')
      .then(res => res.json())
      .then(data => {
        list.innerHTML = '';

        // Add items twice for smooth infinite loop
        function addItems(dataset) {
          dataset.forEach(partner => {
            const media = partner.medias?.[0];
            if (media?.uuid) {
              const li = document.createElement('li');
              const img = document.createElement('img');
              img.src = basePath + media.uuid;
              img.alt = partner.alt_text || 'Partner Logo';
              li.appendChild(img);
              list.appendChild(li);
            }
          });
        }

        addItems(data);
        addItems(data);
      })
      .catch(err => console.error('Error loading partner data:', err));

    // Touch/Swipe drag support
    list.addEventListener('pointerdown', (e) => {
      isDragging = true;
      list.classList.add('dragging');
      startX = e.pageX;
      // Pause animation and calculate current transform value
      const style = window.getComputedStyle(list);
      const matrix = new DOMMatrixReadOnly(style.transform);
      scrollLeft = matrix.m41; // current translateX
      e.preventDefault();
    });

    list.addEventListener('pointermove', (e) => {
      if (!isDragging) return;
      const x = e.pageX;
      const walk = x - startX;
      // Apply transform based on drag distance + current transform
      list.style.transform = `translateX(${scrollLeft + walk}px)`;
    });

    list.addEventListener('pointerup', (e) => {
      isDragging = false;
      list.classList.remove('dragging');
      // Resume animation, reset transform for smooth loop
      list.style.transform = '';
    });

    list.addEventListener('pointerleave', (e) => {
      if (isDragging) {
        isDragging = false;
        list.classList.remove('dragging');
        list.style.transform = '';
      }
    });
  });
</script>
