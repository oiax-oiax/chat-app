<img class="chat-button" src="img/bot.webp" alt="chatbutton">
<div class="chat-area">
    <div class="chat-wrapper">

        <h3>Q&Aチャット</h3>

        <div id="chat-history">
            <?php foreach ($_SESSION['chat_history'] as $entry): ?>
                <p style="margin: 20px 0;">
                    <?= htmlspecialchars($entry['question']) ?><br><br>
                    <strong>
                        <?= htmlspecialchars($entry['answer']) ?>
                    </strong>
                </p>
            <?php endforeach; ?>
        </div>

        <div id="question-container">
            <img id="chat-bot" src="img/bot.webp" alt="chat-bot">
            <div class="chat-quit">❌</div>
            <div class="fukidashi"></div>
            <p id="current-question">
                <span class="current-question-text">
                    <?= htmlspecialchars($current_question['question']) ?>
                </span>
            </p>
            <div id="options-container">
                <?php foreach ($current_question['options'] as $option => $key): ?>
                    <button class="option" data-key="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($option) ?></button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<script src="js/chat.js"></script>