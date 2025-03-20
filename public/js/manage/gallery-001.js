class ManageGallery extends Manage {

    constructor() {
        super(URL_LANG + "/manage/gallery/");
        this.paths.image = URL_PATH +"/image/gallery/";
    }

    // INIT DOM -------------------------------------------------

    initCards() {

        const lazyImages = [].slice.call(document.querySelectorAll("img.lazy-image"));
        if ("IntersectionObserver" in window) {
            let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        let lazyImage = entry.target;
                        lazyImage.src = lazyImage.dataset.src;
                        
                        lazyImage.onload = () => {
                            lazyImage.style.opacity = 1;
                            lazyImage.closest('.card-image').classList.add('loaded');
                        };

                        lazyImage.classList.remove("lazy-image");
                        lazyImageObserver.unobserve(lazyImage);
                    }
                });
            });

            lazyImages.forEach(function(lazyImage) {
                lazyImageObserver.observe(lazyImage);
            });
        }

        document.querySelectorAll('#manage-view-cards .open-modal').forEach(img => {
            img.addEventListener('click', () => {

                const template = document.createElement('template');
                template.innerHTML = this.htmlModalGallery(img);

                const modalElement = template.content.firstElementChild;
                document.body.appendChild(modalElement);
                
                const bsModal = new bootstrap.Modal(modalElement);
                bsModal.show();

                modalElement.addEventListener('hidden.bs.modal', () => {
                    modalElement.remove();
                });

                document.addEventListener('keydown', (e) => {
                    if (e.key === "Escape") {
                        bsModal.hide();
                    }
                });

            });
        });

        document.querySelectorAll('#manage-view-cards .card').forEach(card => {
            card.querySelector('.manage-update')?.addEventListener('click', () => {
                this.showSelectedItem(card.dataset.key);
            });

            card.querySelector('.manage-delete')?.addEventListener('click', () => {
                this.submitKey = card.dataset.key;
                this.deleteData();
            });

            card.querySelector('.manage-copy')?.addEventListener('click', (event) => {
                const text = card.querySelector('.card-link a')?.textContent;
                copyText(event, text);
            });
        });
    }
    
    initFilter() {

        const filterCard = ()=> {
            const cards = document.querySelectorAll("#manage-view-cards .card");
            const input = document.getElementById("manage-filter");
            const filter = normalizeText(input.value);

            let count = 0;
            cards.forEach(card => {
                let display = "none";
                const cardText = normalizeText(card.textContent);
                if (cardText.includes(filter)) {
                    display = "";
                    count++;
                } 
                
                card.parentElement.style.display = display;
            });

            if (count == 0) {
                this.viewEmpty();
            } else {
                this.viewSuccess();
            }
        };

        document.getElementById("manage-filter-clean")?.addEventListener("click", () => {
            document.getElementById("manage-filter").value = "";
            filterCard();
        });

        document.getElementById("manage-filter")?.addEventListener("input", (e) => {
            filterCard();
        });
    }
    
    // VIEW -----------------------------------------------------------

    printViewData() {
        const elementCards = document.querySelector("#manage-view-cards .cards-container");
        if (elementCards) {
            elementCards.innerHTML = '';

            let count = 0;
            Object.entries(this.data).forEach(([key, item]) => {
                if (typeof item === "object") {
                    const template = document.createElement('template');
                    template.innerHTML = this.htmlCard(count, key, item)?.trim();

                    const card = template.content.firstElementChild;
                    card.style.transition = "opacity 0.3s ease-in";
                    card.style.opacity = 0;
                    void card.offsetWidth;

                    elementCards.appendChild(card);
                    setTimeout(() => {
                        card.style.opacity = 1;
                    }, 50);

                    count++;
                }
            });
        }

        setTimeout(() => {
            this.initCards();
        }, 100);
    }
    
    // HTML -----------------------------------------------------------

    htmlCard(index, key, item) {
        const elementDetails = document.querySelector("#manage-details");

        let date;
        try {
            date = new Date(item.date_at?.replace(' ', 'T'));
            if (isNaN(parsedDate.getTime())) {
                date = new Date();
            }
        } catch (e) {
            date = new Date();
        }
        
        let textDate = '';
        let titleCopy = '';
        let titleUpdate = '';
        let titleDelete = '';
        if (elementDetails) {
            textDate = elementDetails.getAttribute('data-text-date')?.replace('[[date]]', date.toLocaleString());
            titleCopy = elementDetails.getAttribute('data-title-copy');
            titleUpdate = elementDetails.getAttribute('data-title-update');
            titleDelete = elementDetails.getAttribute('data-title-delete');
        }

        const imageExt = item.image?.split('.').pop();
        const image = `${this.paths.image}${key}.${imageExt}`;

        return `
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
            <div class="card" data-index="${index}" data-key="${key}" >
                <div class="card-image">
                    <img data-src=${image}" alt="${item.name}" class="open-modal lazy-image" />
                </div>
                <div class="card-body">
                    <div class="card-link d-flex align-items-center">
                        <a href="${image}" target="_blank" 
                            class="flex-grow-1 text-truncate text-decoration-none" 
                            title="${window.location.hostname}${image}">
                            ${window.location.hostname}${image}
                        </a>
                        <i class="bi bi-clipboard ms-2 manage-copy" title="${titleCopy}"></i>
                    </div>
                    <div class="card-text">
                        <h5 class="title" title="${item.name}">${item.name}</h5>
                        <small class="date" title="${date.toLocaleString()}">${textDate}</small>
                    </div>
                </div>
                <div class="card-icons">
                    <i class="bi bi-pencil-square manage-update" title="${titleUpdate}"></i>
                    <i class="bi bi-trash3 delete manage-delete" title="${titleDelete}"></i>
                </div>
            </div>
        </div>`;
    }
    
    htmlModalGallery(img) {
        return `
        <div id="modal-gallery" class="modal fade" tabindex="-1">
            <div class="modal-gallery modal-dialog modal-dialog-centered modal-fullscreen">
                <div class="modal-content bg-dark position-relative">
                    <button type="button" class="btn-close btn-close-white position-absolute" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-body d-flex justify-content-center align-items-center p-0">
                        <div class="zoom-container">
                            <img src="${img.src}" alt="${img.alt}">
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
    }

}