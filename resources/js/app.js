import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const updateLiveClocks = () => {
	const now = new Date();
	const date = new Intl.DateTimeFormat(undefined, {
		weekday: 'short',
		year: 'numeric',
		month: 'short',
		day: 'numeric',
	}).format(now);
	const time = new Intl.DateTimeFormat(undefined, {
		hour: '2-digit',
		minute: '2-digit',
		second: '2-digit',
	}).format(now);
	const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone || 'Local time';

	document.querySelectorAll('[data-live-clock]').forEach((clock) => {
		const dateElement = clock.querySelector('[data-live-date]');
		const timeElement = clock.querySelector('[data-live-time]');
		const timezoneElement = clock.querySelector('[data-live-timezone]');

		if (dateElement) {
			dateElement.dateTime = now.toISOString();
			dateElement.textContent = date;
		}

		if (timeElement) {
			timeElement.dateTime = now.toISOString();
			timeElement.textContent = time;
		}

		if (timezoneElement) {
			timezoneElement.textContent = timezone.replace(/_/g, ' ');
		}
	});
};

updateLiveClocks();
window.setInterval(updateLiveClocks, 1000);
