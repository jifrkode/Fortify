document.addEventListener('DOMContentLoaded', function() {
  var modal = document.getElementById("myModal");
  var span = document.getElementsByClassName("close")[0];
  var modalBody = document.getElementById("modal-body");

  // モーダルを開く
  function openModal(content) {
    modalBody.innerHTML = content;
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

  // 詳細ボタンをクリックしてモーダルを開く
  document.querySelectorAll('.show-detail-button').forEach(function(button) {
    button.addEventListener('click', function() {
      var contactId = this.getAttribute('data-id');
      
      // AJAXリクエストで詳細情報を取得
      fetch(`/contacts/${contactId}`)
        .then(response => response.text())
        .then(data => openModal(data))
        .catch(error => console.error('Error:', error));
    });
  });
});
