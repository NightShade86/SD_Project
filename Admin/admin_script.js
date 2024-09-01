const main = document.querySelector('main');

// Load content for each feature when a link is clicked
document.querySelectorAll('nav a').forEach(link => {
  link.addEventListener('click', event => {
    event.preventDefault();
    const feature = link.getAttribute('href').replace('#', '');
    loadContent(feature);
  });
});

async function loadContent(feature) {
  try {
    main.innerHTML = '<div class="loading">Loading...</div>';

    if (feature === 'view-profile') {
      // Redirect to profile.html
      window.location.href = 'profile.html';
      return;
    }

    if (feature === 'view-feedback') {
      // Handle feedback feature
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
          const feedbackHtml = data.map(item => `<p>${item.message}</p>`).join('');
          feedbackContent.innerHTML = feedbackHtml;
        } else {
          throw new Error('Feedback content element not found');
        }
      } else {
        throw new Error('Feedback section element not found');
      }
      return;
    }

    const response = await fetch(`admin_api.php?feature=${feature}`);
    if (!response.ok) {
      throw new Error(`Error fetching data: ${response.statusText}`);
    }

    const text = await response.text();
    let data;
    try {
      data = JSON.parse(text);
    } catch (e) {
      throw new Error('Error parsing JSON');
    }

    const content = document.createElement('div');
    content.className = 'content';
    
    content.innerHTML = generateContent(data);

    main.innerHTML = '';
    main.appendChild(content);
  } catch (error) {
    main.innerHTML = `<div class="error">Failed to load content: ${error.message}</div>`;
  }
}

function generateProfileForm(data) {
  return `
    <h4>Edit Profile</h4>
    <form id="profile-form">
      <div class="form-group">
        <label for="profile-pic">Profile Picture</label>
        <input type="file" class="form-control" id="profile-pic" accept="image/*">
      </div>
      <div class="form-group">
        <label for="address">Address</label>
        <input type="text" class="form-control" id="address" value="${data.address || ''}">
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" value="${data.email || ''}">
      </div>
      <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
  `;
}

document.addEventListener('DOMContentLoaded', () => {
  const profileForm = document.getElementById('profile-form');
  
  if (profileForm) {
    profileForm.addEventListener('submit', async (event) => {
      event.preventDefault();
      
      const profilePicInput = document.getElementById('profile-pic');
      const address = document.getElementById('address').value;
      const email = document.getElementById('email').value;

      const formData = new FormData();
      formData.append('profile_pic', profilePicInput.files[0]);
      formData.append('address', address);
      formData.append('email', email);

      try {
        const response = await fetch('update_profile.php', {
          method: 'POST',
          body: formData
        });

        const result = await response.json();
        if (response.ok) {
          alert('Profile updated successfully!');
        } else {
          alert('Error updating profile: ' + result.error);
        }
      } catch (error) {
        alert('Error updating profile: ' + error.message);
      }
    });
  }
});

function generateContent(data) {
  return data.map(item => `<p>${JSON.stringify(item)}</p>`).join('');
}
