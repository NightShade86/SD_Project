async function loadContent(feature) {
  try {
    main.innerHTML = '<div class="loading">Loading...</div>';

    // Handle profile redirection
    if (feature === 'view-profile') {
      window.location.href = 'profile.php';
      return;
    }

    // Handle feedback feature
    if (feature === 'view-feedback') {
      const profileSection = document.getElementById('profile-section');
      if (profileSection) profileSection.style.display = 'none';

      const feedbackSection = document.getElementById('feedback-section');
      if (feedbackSection) {
        feedbackSection.style.display = 'block';

        const feedbackContent = document.getElementById('feedback-content');
        if (feedbackContent) {
          const response = await fetch('api.php?feature=view-feedback');
          if (!response.ok) {
            throw new Error(`Error fetching feedback data: ${response.statusText}`);
          }

          const data = await response.json();
          console.log('Feedback data:', data);  // Log data for debugging

          if (Array.isArray(data)) {
            const feedbackHtml = data.map(item => `<p>${item.message}</p>`).join('');
            feedbackContent.innerHTML = feedbackHtml;
          } else {
            feedbackContent.innerHTML = `<p>No feedback data available.</p>`;
          }
        } else {
          throw new Error('Feedback content element not found');
        }
      } else {
        throw new Error('Feedback section element not found');
      }
      return;
    }

		// Fetch content for other features
	const response = await fetch(`admin_api.php?feature=${feature}`);
	if (!response.ok) {
	  throw new Error(`Error fetching data: ${response.statusText}`);
	}

	const text = await response.text();
	console.log('API response:', text);  // Log response text for debugging

	let data;
	try {
	  data = JSON.parse(text);
	} catch (e) {
	  throw new Error('Error parsing JSON');
	}

	// Check if data is an array, otherwise handle it as a single object or other type
	const content = document.createElement('div');
	content.className = 'content';
	console.log('Data:', data);
	// Replace this block with the updated code
	if (Array.isArray(data)) {
	  content.innerHTML = generateContent(data);  // Map over the array
	} else if (typeof data === 'object') {
	  // Handle object response, e.g., for the view-profile feature
	  content.innerHTML = `<p>Profile ID: ${data.id}</p><p>Profile Picture: ${data.profile_pic}</p><p>Address: ${data.address}</p><p>Email: ${data.email}</p>`;
	} else {
	  console.error('Unexpected data format:', data);
	  content.innerHTML = '<p>Unexpected data format</p>';
	}

	main.innerHTML = '';
	main.appendChild(content);

function generateContent(data) {
  return data.map(item => `
    <div>
      <h5>${item.title}</h5>
      <p>${item.description}</p>
    </div>
  `).join('');
}
