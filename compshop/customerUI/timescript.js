document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('date');
    const timeSlotsContainer = document.getElementById('time-slots');

    dateInput.addEventListener('change', function () {
        const selectedDate = this.value;

        if (!selectedDate) return;

        fetch(`get_reserved_times.php?date=${encodeURIComponent(selectedDate)}`)
            .then(response => response.json())
            .then(reservedTimes => {
                const times = [
                    "12:00:00", "12:30:00", "13:00:00", "13:30:00",
                    "14:00:00", "14:30:00", "15:00:00", "15:30:00",
                    "16:00:00", "16:30:00"
                ];

                timeSlotsContainer.innerHTML = '';

                times.forEach(time => {
                    const formattedTime = new Date(`1970-01-01T${time}Z`).toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    });

                    const isDisabled = reservedTimes.includes(time);
                    const label = document.createElement('label');
                    label.innerHTML = `
                        ${formattedTime}
                        <input type="radio" name="time" value="${time}" ${isDisabled ? 'disabled' : ''} required>
                        ${isDisabled ? ' (Unavailable)' : ''}
                    `;
                    timeSlotsContainer.appendChild(label);
                    timeSlotsContainer.appendChild(document.createElement('br'));
                });
            })
            .catch(error => {
                console.error('Error fetching reserved times:', error);
            });
    });
});
