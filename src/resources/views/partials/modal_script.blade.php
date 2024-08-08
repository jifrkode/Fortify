<script>
// モーダルを表示するためのJavaScript
var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];

// モーダルを開く
function openModal() {
  modal.style.display = "block";
}

// モーダルを閉じる
span.onclick = function() {
  modal.style.display = "none";
}

// モーダルの外側をクリックすると閉じる
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
