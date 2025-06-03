class AsyncLoader {
  constructor({
    apiUrl,
    targetSelector,
    templateUrl,
    paginationSelector = null,
  }) {
    this.apiUrl = apiUrl;
    this.target = document.querySelector(targetSelector);
    this.pagination = paginationSelector
      ? document.querySelector(paginationSelector)
      : null;
    this.templateUrl = templateUrl;
    this.template = "";
    this.params = new URLSearchParams(window.location.search);

    this.init();
  }

  async init() {
    await this.loadTemplate();
    this.bindEvents();
    this.loadData();
    window.addEventListener("popstate", () => this.loadData());
  }

  async loadTemplate() {
    const res = await fetch(this.templateUrl);
    if (!res.ok) throw new Error("Помилка завантаження шаблону");
    this.template = await res.text();
  }

  bindEvents() {
    document.addEventListener("change", (e) => {
      if (!e.target.matches('[data-filter][type="checkbox"]')) return;

      const name = e.target.name;
      const value = e.target.value;
      const paramName = `${name}[]`;

      const values = this.params.getAll(paramName);

      if (e.target.checked && !values.includes(value)) {
        this.params.append(paramName, value);
      } else if (!e.target.checked) {
        const updated = values.filter((v) => v !== value);
        this.params.delete(paramName);
        updated.forEach((v) => this.params.append(paramName, v));
      }

      this.params.delete("page");
      this.updateUrl();
      this.loadData();
    });

    if (this.pagination) {
      this.pagination.addEventListener("click", (e) => {
        if (e.target.matches("[data-page]")) {
          const page = e.target.dataset.page;
          this.params.set("page", page);
          this.updateUrl();
          this.loadData();
        }
      });
    }
  }

  updateUrl() {
    const newUrl = `${window.location.pathname}?${this.params.toString()}`;
    window.history.pushState({}, "", newUrl);
  }

  async loadData() {
    const res = await fetch(`${this.apiUrl}?${this.params.toString()}`);
    const data = await res.json();
    this.renderItems(data.items);
    if (this.pagination && data.pagination) {
      this.renderPagination(data.pagination);
    }
  }

  renderItems(items) {
    this.target.innerHTML = "";
    items.forEach((item) => {
      const html = this.template.replace(
        /\{\{(.*?)\}\}/g,
        (_, key) => item[key.trim()] ?? ""
      );
      this.target.insertAdjacentHTML("beforeend", html);
    });
  }

  renderPagination(pagination) {
    this.pagination.innerHTML = "";

    const totalPages = pagination.totalPages;
    const currentPage = parseInt(pagination.currentPage);
    const maxPages = 5;

    if (currentPage > 1) {
      const firstPageBtn = document.createElement("button");
      firstPageBtn.textContent = "<<";
      firstPageBtn.className = "btn btn-sm mx-1 btn-outline-primary";
      firstPageBtn.dataset.page = currentPage - 1;
      this.pagination.appendChild(firstPageBtn);
    }

    let startPage = Math.max(1, currentPage - Math.floor(maxPages / 2));
    let endPage = Math.min(totalPages, startPage + maxPages - 1);

    if (endPage - startPage < maxPages - 1) {
      startPage = Math.max(1, endPage - maxPages + 1);
    }

    for (let i = startPage; i <= endPage; i++) {
      const pageBtn = document.createElement("button");
      pageBtn.textContent = i;
      pageBtn.dataset.page = i;
      pageBtn.className =
        "btn btn-sm mx-1 " +
        (i === currentPage ? "btn-primary" : "btn-outline-primary");
      this.pagination.appendChild(pageBtn);
    }

    if (currentPage < totalPages) {
      const lastPageBtn = document.createElement("button");
      lastPageBtn.textContent = ">>";
      lastPageBtn.className = "btn btn-sm mx-1 btn-outline-primary";
      lastPageBtn.dataset.page = currentPage + 1;
      this.pagination.appendChild(lastPageBtn);
    }

    this.pagination.querySelectorAll("button").forEach((button) => {
      button.addEventListener("click", (e) => {
        const page = e.target.dataset.page;
        this.params.set("page", page);
        this.updateUrl();
        this.loadData();
      });
    });
  }

  applyFilters(extraParams = {}) {
    for (const key of Array.from(this.params.keys())) {
      if (key.endsWith("[]") || key === "page") {
        this.params.delete(key);
      }
    }

    const filterElements = document.querySelectorAll(
      "[data-filter][type='text']"
    );

    filterElements.forEach((el) => {
      const name = el.name;
      const value = el.value.trim();

      if (!name) return;
      if (value !== "") {
        this.params.set(name, value);
      }
    });

    for (const [key, value] of Object.entries(extraParams)) {
      this.params.set(key, value);
    }

    this.updateUrl();
    this.loadData();
  }
}
