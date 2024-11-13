<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SESSION['loggedin']) {
    $userid = $_SESSION['USER_ID'];
    $role = $_SESSION['role'];
}else{
    $userid ='Guest';
    $role = 'Guest';
}

?>

<div style="padding: 30px">
    <form method="post" action="feedback_process.php">
        <h2>Feedback Form</h2>

        <div class="form-group">
            <label for="ic" style="font-weight: bold; color: #333;">First Name</label>
            <input type="text" id="fname" name="fname" placeholder="Please enter your first name" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
        </div>

        <div class="form-group">
            <label for="ic" style="font-weight: bold; color: #333;">Last Name</label>
            <input type="text" id="lname" name="lname" placeholder="Please enter your last name" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
        </div>

        <div class="form-group">
            <label for="ic" style="font-weight: bold; color: #333;">Email</label>
            <input type="email" id="email" name="email" placeholder="Please enter your email" required style="width: 100%; padding: 10px; margin-bottom: 10px; border: none; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
        </div>

        <h3>1. Rating System</h3>

        <label for="overall_rating">Overall Satisfaction (1-10):</label><br>
        <input type="range" name="overall_rating" id="overall_rating" min="1" max="10" value="5" oninput="updateValue('overall_rating_value', this.value)">
        <span id="overall_rating_value">5</span><br><br>

        <label for="design_rating">Design (1-10):</label><br>
        <input type="range" name="design_rating" id="design_rating" min="1" max="10" value="5" oninput="updateValue('design_rating_value', this.value)">
        <span id="design_rating_value">5</span><br><br>

        <label for="usability_rating">Usability (1-10):</label><br>
        <input type="range" name="usability_rating" id="usability_rating" min="1" max="10" value="5" oninput="updateValue('usability_rating_value', this.value)">
        <span id="usability_rating_value">5</span><br><br>

        <label for="performance_rating">Performance (1-10):</label><br>
        <input type="range" name="performance_rating" id="performance_rating" min="1" max="10" value="5" oninput="updateValue('performance_rating_value', this.value)">
        <span id="performance_rating_value">5</span><br><br>

        <label for="content_rating">Content Relevance (1-10):</label><br>
        <input type="range" name="content_rating" id="content_rating" min="1" max="10" value="5" oninput="updateValue('content_rating_value', this.value)">
        <span id="content_rating_value">5</span><br><br>

        <h3>2. Open-ended Questions</h3>
        <label for="positive_feedback">What did you like most about our website?</label><br>
        <textarea name="positive_feedback" required></textarea><br><br>

        <label for="improvements">What can we improve?</label><br>
        <textarea name="improvements" required></textarea><br><br>

        <label for="missing_info">Was there anything you were looking for but couldn’t find?</label><br>
        <textarea name="missing_info" required></textarea><br><br>

        <h3>3. Multiple-choice Questions</h3>
        <label for="navigation_difficulty">How easy was it to navigate the website?</label><br>
        <select name="navigation_difficulty">
            <option value="Very Easy">Very Easy</option>
            <option value="Easy">Easy</option>
            <option value="Neutral">Neutral</option>
            <option value="Difficult">Difficult</option>
            <option value="Very Difficult">Very Difficult</option>
        </select><br><br>

        <label for="visit_reason">What best describes your reason for visiting?</label><br>
        <select name="visit_reason">
            <option value="Browsing">Browsing</option>
            <option value="Looking for Information">Looking for Information</option>
            <option value="Customer Support">Customer Support</option>
            <option value="Create an account">Create an account</option>
            <option value="Create an appointment">Create an appointment</option>

        </select><br><br>

        <label for="website_discovery">How did you find our website?</label><br>
        <select name="website_discovery">
            <option value="Search Engine">Search Engine</option>
            <option value="Social Media">Social Media</option>
            <option value="Referral">Referral</option>
        </select><br><br>

        <h3>4. Usability & Functionality</h3>
        <label for="functionality_issue">Did any part of the site not work as expected?</label><br>
        <textarea name="functionality_issue" required></textarea><br><br>

        <label for="loading_speed">Did the website load quickly?</label><br>
        <select name="loading_speed">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select><br><br>

        <h3>5. NPS (Net Promoter Score)</h3>
        <label for="design_rating">How likely are you to recommend our website to a friend? (0-10)</label><br>
        <input type="range" name="recommendation_rate" id="recommendation_rate" min="1" max="10" value="5" oninput="updateValue('recomendation_rate_value', this.value)">
        <span id="recomendation_rate_value">5</span><br><br>


        <h3>6. Additional Comments</h3>
        <label for="additional_comments">Any additional comments or suggestions?</label><br>
        <textarea name="additional_comments"></textarea><br><br>

        <h3>8. Consent for Follow-up</h3>
        <label for="follow_up">Would you like to be contacted about your feedback?</label><br>
        <select name="follow_up">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select><br><br>

        <input type="hidden" value="<?php echo $userid; ?>" name="userid" id="userid">
        <input type="hidden" value="<?php echo $role; ?>" name="role" id="role">


        <button type="submit" class="btn btn-primary">Submit</button>

    </form>
</div>

<!-- Scripts -->
<script>
    function updateValue(spanId, value) {
        document.getElementById(spanId).textContent = value;
    }
</script>


