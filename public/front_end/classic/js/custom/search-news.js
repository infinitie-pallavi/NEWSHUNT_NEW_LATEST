document.getElementById('filterForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const checkboxes = document.querySelectorAll('input[name="channel[]"]:checked');
    const selectedChannels = Array.from(checkboxes).map(checkbox => checkbox.value);
    
    const channelValue = selectedChannels.join('|');
    
    const hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.value = channelValue;
    
    const existingHidden = document.querySelector('input[name="selected_channels"]');
    if (existingHidden) {
        existingHidden.remove();
    }
    
    this.appendChild(hiddenInput);
    this.submit();
});