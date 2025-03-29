<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell My Phone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .upload-container {
            background: linear-gradient(135deg, #ff00ff, #6a00f4);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(255, 255, 255, 0.2);
            text-align: center;
            position: relative;
        }
        .upload-box {
            background: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .upload-icon {
            font-size: 40px;
            color: #888;
        }
        .btn-upload {
            margin-top: 10px;
            background-color: #9c27b0;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-upload:hover {
            background-color: #7b1fa2;
        }
        #imagePreview img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 2px solid #ddd;
            border-radius: 5px;
            margin: 10px;
        }
        #imagePreview  {
            height: 40%;
            border: 2px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h2 class="text-center mb-4">Sell My Phone</h2>
            <form>
                <div class="mb-3">
                    <label for="phoneName" class="form-label">Mobile Phone Name</label>
                    <input type="text" class="form-control" id="phoneName" placeholder="Enter phone name" required>
                </div>
                <div class="mb-3">
                    <label for="phonePrice" class="form-label">Price ($)</label>
                    <input type="number" class="form-control" id="phonePrice" placeholder="Enter price" required>
                </div>

                <div class="mb-6 mt-6 text-center">
                    <input type="file" id="phoneImages" class="d-none" multiple accept="image/*" onchange="validateFiles(this)">
                    <button type="button" class="btn btn-upload" onclick="document.getElementById('phoneImages').click()">📤</button>
                    <div id="imagePreview"></div>
                </div>
               
                <div class="mb-3">
                    <label for="phoneCondition" class="form-label">Rate Condition (out of 10): <span id="conditionValue">5</span></label>
                    <input type="range" class="form-range" id="phoneCondition" min="1" max="10" step="1" value="5" oninput="document.getElementById('conditionValue').textContent = this.value;">
                </div>
                <div class="mb-3">
                    <label for="phoneDetails" class="form-label">Phone Details</label>
                    <textarea class="form-control" id="phoneDetails" rows="4" placeholder="Enter details about your phone"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateFiles(input) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = "";
            if (input.files.length > 7) {
                alert("You can upload a maximum of 7 images.");
                input.value = "";
                return;
            }
            for (let i = 0; i < input.files.length; i++) {
                const file = input.files[i];
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('img-thumbnail');
                    img.style.width = '100px';
                    img.style.height = '100px';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
