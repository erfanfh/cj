const searchQuery = document.getElementById("search");
const searchBtn = document.getElementById("submit");

searchBtn.onclick = function () {
  const xhr = new XMLHttpRequest();
  xhr.responseType = "json";
  let queryString = new URLSearchParams();
  queryString.append("search", searchQuery.value);
  queryString.append("ext", "js");
  queryString = "?" + queryString.toString();
  xhr.open("GET", location.origin + "/search.php" + queryString);
  xhr.onload = function () {
    const posts = this.response;
    const tableResult = document.querySelector("#search-ajax-result tbody");
    F;
    tableResult.innerHTML = "";
    if (0 < posts.length) {
      for (const post of posts) {
        const htmlTemplate = ajaxHtmlResult(post);
        tableResult.innerHTML += htmlTemplate;
      }
    } else {
      tableResult.innerHTML += "موردی یافت نشد";
    }
  };

  xhr.onerror = function () {
    console.warn("[XHR Error]");
  };

  xhr.send();
};

function ajaxHtmlResult(data) {
  const templateHtml = `<a href="${data.link}">${data.title}</a><img src="${data.thumbnail}" class="rapidcode-lazy-image-load medium-zoom-image" style="background-image: none;">`;

  return templateHtml;
}
