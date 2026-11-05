(function () {
    function ReusableSearch(options) {
        const input = document.getElementById(options.inputId);
        const resultBox = document.getElementById(options.resultId);

        if (!input || !resultBox) return;

        const url = options.url;
        const minLength = options.minLength || 3;
        const delay = options.delay || 300;

        let timer = null;

        // page load → hidden
        resultBox.style.display = "none";

        input.addEventListener("keyup", function () {
            const keyword = this.value.trim();
            clearTimeout(timer);

            // less than 3 char → hide
            if (keyword.length < minLength) {
                resultBox.innerHTML = "";
                resultBox.style.display = "none";
                return;
            }

            // show box + searching
            resultBox.style.display = "block";
            resultBox.innerHTML = `<div class="rs-searching">Searching...</div>`;

            timer = setTimeout(() => {
                fetch(`${url}?q=${encodeURIComponent(keyword)}`, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                    .then((res) => res.text())
                    .then((html) => {
                        resultBox.innerHTML = html;
                    })
                    .catch(() => {
                        resultBox.innerHTML = `<div class="rs-error">Something went wrong</div>`;
                    });
            }, delay);
        });

        // outside click → hide
        document.addEventListener("click", function (e) {
            if (!input.contains(e.target) && !resultBox.contains(e.target)) {
                resultBox.style.display = "none";
            }
        });
    }

    window.ReusableSearch = ReusableSearch;
})();
