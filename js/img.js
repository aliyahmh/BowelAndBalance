// Ensure the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('profile-img');
    const fileDisplay = document.getElementById('file-upload');
    const fileUploadLabel = document.getElementById('file-upload-label');
    
    if (fileInput && fileDisplay) {
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const file = this.files[0];
                fileDisplay.value = file.name;
                
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        // ===== LECTURE 9: String Concatenation =====
                        fileUploadLabel.innerHTML = '<img src="' + e.target.result + '" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">';
                    };
                    
                    reader.readAsDataURL(file);
                } else {
                    fileUploadLabel.innerHTML = `
                        <span class="icon-wrapper">
                            <i class="fas fa-image main-icon"></i>
                            <i class="fas fa-plus badge-icon"></i>
                        </span>
                    `;
                }
            } else {
                fileDisplay.value = '';
                fileUploadLabel.innerHTML = `
                    <span class="icon-wrapper">
                        <i class="fas fa-image main-icon"></i>
                        <i class="fas fa-plus badge-icon"></i>
                    </span>
                `;
            }
        });
    }

    
});