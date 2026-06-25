<style>
    /* Basic styling for modal */
    .modal {
      display: none; /* Hidden by default */
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    }
    .modal-content {
      position: relative;
      margin: 15% auto;
      padding: 20px;
      width: 80%;
      max-width: 500px;
      background-color: white;
      border-radius: 8px;
      text-align: center;
    }
    .close {
      position: absolute;
      top: 10px;
      right: 20px;
      cursor: pointer;
      font-size: 24px;
    }
    /* Button styling */
    #openModalButton {
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      border: none;
      border-radius: 5px;
      background-color: #4CAF50;
      color: white;
    }
  </style>
</head>
<body>
<button id="openModalButton">Open Modal</button>

  <!-- Modal structure -->
  <div id="myModal" class="modal">
    <div class="modal-content">
      <span id="closeModal" class="close">&times;</span>
      <h2>Modal Header</h2>
      <p>Some content inside the modal.</p>
    </div>
  </div>

  <script>
    // JavaScript to control modal behavior
    const modal = document.getElementById('myModal');
    const openModalButton = document.getElementById('openModalButton');
    const closeModalButton = document.getElementById('closeModal');

    // Open the modal
    openModalButton.onclick = function() {
      modal.style.display = 'block';
    }

    // Close the modal when clicking the "x" button
    closeModalButton.onclick = function() {
      modal.style.display = 'none';
    }

    // Close the modal if the user clicks outside the modal content
    window.onclick = function(event) {
      if (event.target === modal) {
        modal.style.display = 'none';
      }
    }
  </script>
