const images = [
    'imgs/BEI_1104_original.jpg',
    'imgs/BEI_889_original.jpg',
    'imgs/BEI_178_aspect16x9.jpg',
    'imgs/BEI_161_original.jpg',
    'imgs/BEI_133_original.jpg',
];

const carouselInner = document.querySelector('.carousel-inner');
let currentIndex = images.length; // Start at the first "real" image in the middle of clones

// Create the infinite looping structure
function initializeCarousel() {
    // Clone the images for smooth infinite scrolling
    const totalClones = 10; // Number of loops to show before and after
    for (let i = 0; i < totalClones; i++) {
        images.forEach((src) => {
            const divCloneStart = document.createElement('div');
            divCloneStart.className = 'carousel-item';
            divCloneStart.innerHTML = `<img src="${src}" alt="Image Clone">`;
            carouselInner.appendChild(divCloneStart);

            const divCloneEnd = document.createElement('div');
            divCloneEnd.className = 'carousel-item';
            divCloneEnd.innerHTML = `<img src="${src}" alt="Image Clone">`;
            carouselInner.prepend(divCloneEnd);
        });
    }

    // Populate the original images
    images.forEach((src, index) => {
        const div = document.createElement('div');
        div.className = 'carousel-item';
        div.innerHTML = `<img src="${src}" alt="Image ${index + 1}">`;
        carouselInner.appendChild(div);
    });

    // Add click listeners to dynamically select an image
    addClickListeners();

    // Set the initial visible state
    updateCarousel();
}

// Update the carousel's visible state
function updateCarousel() {
    const items = document.querySelectorAll('.carousel-item');
    const offset = -(currentIndex - 1) * 100 / 3; // Center the active image (1 before and 1 after visible)
    carouselInner.style.transform = `translateX(${offset}%)`;

    // Reset classes for active item
    items.forEach((item, index) => {
        item.classList.remove('active');
        if (index === currentIndex) item.classList.add('active');
    });
}

// Add click listeners to each carousel item
function addClickListeners() {
    const items = document.querySelectorAll('.carousel-item');
    items.forEach((item, index) => {
        item.addEventListener('click', () => {
            currentIndex = index;
            updateCarousel();
        });
    });
}

// Infinite scrolling adjustment
function adjustForInfiniteScrolling() {
    const items = document.querySelectorAll('.carousel-item');

    if (currentIndex < images.length) {
        currentIndex += images.length; // Move forward in clones
    } else if (currentIndex >= items.length - images.length) {
        currentIndex -= images.length; // Move backward in clones
    }

    updateCarousel();
}

// Add a transition-end listener to handle infinite scrolling
carouselInner.addEventListener('transitionend', adjustForInfiniteScrolling);

// Initialize the carousel
initializeCarousel();
