<style>
    #userTable td,
    #userTable th {
        padding-left: 10px;
        /* Adjust as needed */
        padding-right: 10px;
        /* Adjust as needed */
    }

    #importirModal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Dark background to cover the page */
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        z-index: 1050;
        /* Ensure the overlay is behind modal content but above other elements */
    }

    .card {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        width: 80%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Adds shadow to create a card effect */
    }

    .card h2 {
        margin-top: 0;
    }

    .modalContent table {
        width: 100%;
        border-collapse: collapse;
    }

    .modalContent th,
    .modalContent td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    button {
        margin-top: 10px;
        padding: 8px 16px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }
</style>

<div class="panel">
    <div class="ribbon ribbon-clip ribbon-primary">
        <span class="ribbon-inner">
            <i class="icon md-view-list margin-0"></i> Monitoring PPJK
        </span>
    </div>
    <div>&nbsp;</div>
    <div>&nbsp;</div>
    <div>&nbsp;</div>

    <div class="panel-group panel-group-continuous" id="exampleAccordionContinuous" aria-multiselectable="true"
        role="tablist">
        <!-- <div class="form-group">
            <label for="search">Pencarian</label>
            <input type="text" class="form-control" id="search"
                placeholder="Cari berdasarkan npwp atau nama perusahaan">
            <button type="submit" class="btn btn-primary" id="searchButton">Cari</button>
        </div> -->
        <div class="panel-body container-fluid">
            <div class="row">
                <div class="form-group form-material"> <label class="col-sm-2 control-label" for="0">NAMA PT atau
                        NPWP</label>
                    <div class="col-sm-10"> <input id="search" class="form-control" type="text" name="form[0][]"
                            value="" tag="" placeholder="NPWP atau NAMA PT">
                        <div class="hint">PENCARIAN DATA NOMOR NPWP ATAU NAMA PT</div>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="col-sm-12" align="center"><button type="reset"
                            class="btn btn-sm btn-danger waves-effect waves-light waves-effect waves-light"
                            onclick="form_reset(&quot;tblrequestgatepassBc&quot;)"><i class="icon md-refresh"></i>
                            CANCEL</button>
                        &nbsp;
                        <button type="submit" id="searchButton"
                            class="btn btn-sm btn-primary waves-effect waves-light waves-effect waves-light"><i
                                class="icon md-search"></i> SEARCH</button>
                    </div>
                </div>
            </div>
        </div>
        <br>


        <table id="userTable" class="tabelajax tablesaw-stack">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Penanggung Jawab</th>
                    <th>Npwp</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <!-- Rows will be populated here -->
            </tbody>
        </table>
        <div class="pagination">
            <button id="prevPage" onclick="changePage(-1)">Previous</button>
            <span id="pageInfo"></span>
            <button id="nextPage" onclick="changePage(1)">Next</button>
        </div>
    </div>

    <div id="importirModal" style="display: none;">
        <div class="card">
            <h2>Importir Details</h2>
            <div id="modalContent" class="modalContent"></div>
            <button onclick="closeModal()">Close</button>
        </div>
    </div>

</div>

<script>
    let currentPage = 1;
    const perPage = 20; // Number of records per page
    let totalEntries = 0; // Total number of entries
    let apiUrl = 'http://103.234.195.126/api/users';
    if (window.location.protocol === 'https:') {
        apiUrl = 'https://osbos.multiterminal.co.id/api/users';
    } else {
        apiUrl = 'http://103.234.195.126/api/users';
    }




    const apiKey = '863e20a2e87cd3266b75ef110da56048'; // Your API key

    const searchInput = document.getElementById('search');
    const searchButton = document.getElementById('searchButton');

    searchButton.addEventListener('click', function () {
        const searchTerm = searchInput.value.trim();
        fetchData(1, searchTerm);  // Trigger search when button is clicked, starting from page 1
    });

    async function fetchData(page, searchTerm = '') {
        try {
            const response = await fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', // Specify the content type
                },
                body: JSON.stringify({
                    key: apiKey,
                    page: page,
                    search: searchTerm // Add the search term to the request body
                })
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            totalEntries = data.total; // Get the total number of entries
            renderTable(data.data); // Render the fetched data
            updatePaginationInfo(data.current_page, Math.ceil(totalEntries / perPage));
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    }

    function renderTable(users) {
        const tableBody = document.getElementById('tableBody');
        tableBody.innerHTML = ''; // Clear existing rows

        users.forEach(item => {
            const row = `<tr>
                    <td>${item.id}</td>
                    <td>${item.name}</td>
                    <td>${item.penanggungjawab}</td>
                    <td>${item.npwp}</td>
                    <td>${item.email}</td>
                    <td>${item.no_telp}</td>
                    <td><button onclick="fetchImportirDetails(${item.id})">Lihat Data Importir</button></td>
                </tr>`;
            tableBody.innerHTML += row;
        });
    }

    function updatePaginationInfo(current, total) {
        document.getElementById('pageInfo').innerText = `Page ${current} of ${total}`;
        document.getElementById('prevPage').disabled = current === 1;
        document.getElementById('nextPage').disabled = current === total;
    }

    function changePage(direction) {
        currentPage += direction;
        fetchData(currentPage); // Fetch data for the new page
    }

    // Initial fetch
    fetchData(currentPage);

    function fetchImportirDetails(idUser) {
        let apiUrldetail = 'http://103.234.195.126/api/importir-details';
        if (window.location.protocol === 'https:') {
            apiUrldetail = 'https://osbos.multiterminal.co.id/api/importir-details';
        } else {
            apiUrldetail = 'http://103.234.195.126/api/importir-details';
        }
        const postData = {
            id_user: idUser,
            key: '863e20a2e87cd3266b75ef110da56048'
        };

        fetch(apiUrldetail, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(postData)
        })
            .then(response => response.json())
            .then(data => {
                displayModal(data);
            })
            .catch(error => console.error('Error fetching importir details:', error));
    }

    function displayModal(importirData) {
        const modal = document.getElementById('importirModal');
        const modalContent = document.getElementById('modalContent');
        modalContent.innerHTML = ''; // Clear previous content

        modalContent.innerHTML = `
            <div class="modalContent">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NPWP</th>
                            <th>Alamat</th>
                            <th>No Telp</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        `;

        importirData.forEach(importir => {
            modalContent.querySelector("tbody").innerHTML += `
        <tr>
            <td>${importir.nama}</td>
            <td>${importir.npwp}</td>
            <td>${importir.alamat}</td>
            <td>${importir.notelp || 'N/A'}</td>
        </tr>
    `;
        });


        modal.style.display = 'flex'; // Show modal
    }

    function closeModal() {
        const modal = document.getElementById('importirModal');
        modal.style.display = 'none';
    }
</script>