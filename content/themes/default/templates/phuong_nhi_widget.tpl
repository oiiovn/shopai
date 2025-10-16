{* Chat GPT Widget Template *}
<div id="chatgpt-widget" class="chatgpt-widget">
    {* Chat Toggle Button *}
    <div id="chatgpt-toggle" class="chatgpt-toggle">
        <img src="src="/TCSN/Script/content/uploads/photos/2025/09/sngine_fe74c972cc54d5d8a5169d0807eb26c7_cropped.jpg?v=1" alt="Phương Nhi" class="toggle-avatar" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        <i class="fas fa-comments" style="display: none;"></i>
        <span class="chatgpt-badge" id="chatgpt-badge" style="display: none;">1</span>
    </div>

    {* Chat Window *}
    <div id="chatgpt-window" class="chatgpt-window" style="display: none;">
        {* Chat Header *}
        <div class="chatgpt-header">
             <div class="chatgpt-header-info">
                 <div class="chatgpt-avatar" id="header-avatar">
                     <img src="/TCSN/Script/content/uploads/photos/2025/09/sngine_fe74c972cc54d5d8a5169d0807eb26c7_cropped.jpg?v=1" alt="Phương Nhi" class="avatar-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                     <i class="fas fa-robot" style="display: none;"></i>
                 </div>
                <div class="chatgpt-header-text">
                    <h6 class="chatgpt-title">Phương Nhi</h6>
                    <span class="chatgpt-status" id="chatgpt-status">Đang hoạt động</span>
                </div>
            </div>
            <div class="chatgpt-header-actions">
                <button type="button" class="chatgpt-minimize" id="chatgpt-minimize">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="chatgpt-close" id="chatgpt-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        {* Chat Messages *}
        <div class="chatgpt-messages" id="chatgpt-messages">
             <div class="chatgpt-message chatgpt-message-bot">
                 <div class="chatgpt-message-avatar" id="welcome-avatar">
                     <img src="/TCSN/Script/content/uploads/photos/2025/09/sngine_fe74c972cc54d5d8a5169d0807eb26c7_cropped.jpg?v=1" alt="Phương Nhi" class="avatar-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                     <i class="fas fa-robot" style="display: none;"></i>
                 </div>
                <div class="chatgpt-message-content">
                    <div class="chatgpt-message-text" id="welcome-message">
                        Xin chào! Em là Phương Nhi, nhân viên hỗ trợ khách hàng của Shop-AI. Em có thể giúp bạn hiểu về các dịch vụ check số Shopee, nạp tiền và nhiều tính năng khác. Bạn cần hỗ trợ gì?
                    </div>
                    <div class="chatgpt-message-time" id="welcome-time"></div>
                </div>
            </div>
        </div>

        {* Chat Input *}
        <div class="chatgpt-input-container">
            <div class="chatgpt-typing" id="chatgpt-typing" style="display: none;">
                <div class="chatgpt-typing-dots">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <span class="chatgpt-typing-text">Trợ lý đang trả lời...</span>
            </div>
            <div class="chatgpt-input-wrapper">
                <textarea 
                    id="chatgpt-input" 
                    class="chatgpt-input" 
                    placeholder="Nhập tin nhắn của bạn..."
                    rows="1"
                ></textarea>
                <button type="button" class="chatgpt-send" id="chatgpt-send">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>
    </div>
</div>

{* Chat GPT Widget Styles *}
<style>
.chatgpt-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.chatgpt-toggle {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #a8e6cf 0%, #88d8c0 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
    position: relative;
}

.chatgpt-toggle:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 25px rgba(0,0,0,0.2);
}

.chatgpt-toggle i {
    color: white;
    font-size: 24px;
}

.toggle-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.chatgpt-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff4757;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
}

.chatgpt-window {
    position: absolute;
    bottom: 80px;
    right: 0;
    width: 350px;
    height: 500px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.chatgpt-header {
    background: linear-gradient(135deg, #a8e6cf 0%, #88d8c0 100%);
    color: white;
    padding: 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.chatgpt-header-info {
    display: flex;
    align-items: center;
}

.chatgpt-avatar {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
    overflow: hidden;
}

.chatgpt-avatar i {
    font-size: 18px;
}

.chatgpt-avatar .avatar-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.chatgpt-title {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.chatgpt-status {
    font-size: 12px;
    opacity: 0.8;
}

.chatgpt-header-actions {
    display: flex;
    gap: 5px;
}

.chatgpt-minimize,
.chatgpt-close {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    padding: 5px;
    border-radius: 3px;
    transition: background 0.2s;
}

.chatgpt-minimize:hover,
.chatgpt-close:hover {
    background: rgba(255,255,255,0.2);
}

.chatgpt-messages {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    background: #f8f9fa;
}

.chatgpt-message {
    display: flex;
    margin-bottom: 15px;
    animation: fadeInUp 0.3s ease;
}

.chatgpt-message-user {
    flex-direction: row-reverse;
}

.chatgpt-message-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 8px;
    flex-shrink: 0;
    overflow: hidden;
}

.avatar-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.chatgpt-message-user .chatgpt-message-avatar {
    margin-left: 4px;
    margin-right: 8px;
}

.chatgpt-message-bot .chatgpt-message-avatar {
    background: #a8e6cf;
    color: white;
}

.chatgpt-message-user .chatgpt-message-avatar {
    background: #28a745;
    color: white;
}

.chatgpt-message-content {
    max-width: 70%;
}

.chatgpt-message-user .chatgpt-message-content {
    margin-left: auto;
    margin-right: 0;
    max-width: 80%;
}

.chatgpt-message-text {
    background: white;
    padding: 10px 15px;
    border-radius: 18px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    word-wrap: break-word;
    line-height: 1.4;
}

.chatgpt-message-user .chatgpt-message-text {
    background: linear-gradient(135deg, #a8e6cf 0%, #88d8c0 100%);
    color: white;
    padding: 12px 16px;
    border-radius: 18px;
    font-size: 14px;
    line-height: 1.4;
}

.chatgpt-message-time {
    font-size: 11px;
    color: #6c757d;
    margin-top: 5px;
    text-align: right;
}

.chatgpt-message-user .chatgpt-message-time {
    text-align: left;
}

.chatgpt-input-container {
    padding: 15px;
    background: white;
    border-top: 1px solid #e9ecef;
}

.chatgpt-typing {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    color: #6c757d;
    font-size: 12px;
}

.chatgpt-typing-dots {
    display: flex;
    gap: 3px;
    margin-right: 8px;
}

.chatgpt-typing-dots span {
    width: 6px;
    height: 6px;
    background: #6c757d;
    border-radius: 50%;
    animation: typing 1.4s infinite;
}

.chatgpt-typing-dots span:nth-child(2) {
    animation-delay: 0.2s;
}

.chatgpt-typing-dots span:nth-child(3) {
    animation-delay: 0.4s;
}

.chatgpt-input-wrapper {
    display: flex;
    align-items: flex-end;
    gap: 10px;
}

.chatgpt-input {
    flex: 1;
    border: 1px solid #e9ecef;
    border-radius: 20px;
    padding: 10px 15px;
    resize: none;
    outline: none;
    font-size: 14px;
    line-height: 1.4;
    max-height: 100px;
    transition: border-color 0.2s;
}

.chatgpt-input:focus {
    border-color: #a8e6cf;
}

.chatgpt-send {
    width: 40px;
    height: 40px;
    background: #a8e6cf;
    border: none;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.chatgpt-send:hover {
    background: #5a6fd8;
    transform: scale(1.05);
}

.chatgpt-send:disabled {
    background: #6c757d;
    cursor: not-allowed;
    transform: none;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes typing {
    0%, 60%, 100% {
        transform: translateY(0);
    }
    30% {
        transform: translateY(-10px);
    }
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .chatgpt-window {
        width: 300px;
        height: 450px;
    }
    
    .chatgpt-widget {
        bottom: 15px;
        right: 15px;
    }
}
</style>

{* Chat GPT Widget JavaScript *}
<script>
class ChatGPTHelper {
     constructor() {
         this.conversationId = null;
         this.sessionId = this.generateSessionId();
         this.isTyping = false;
         this.userName = 'Guest';
         this.userGender = 'unknown';
         this.phuongNhiAvatarUrl = ''; // Avatar URL của Phương Nhi
         this.init();
     }

     init() {
         this.detectUserInfo();
         this.bindEvents();
         this.setWelcomeTime();
         this.generateWelcomeMessage();
         this.loadConversation();
         this.getPhuongNhiAvatar();
     }

    detectUserInfo() {
        try {
            // Try multiple methods to detect user info
            
            // Method 1: Global variables
            if (typeof window.user !== 'undefined' && window.user) {
                this.userName = window.user.name || window.user.user_name || 'Guest';
                this.userGender = window.user.gender || window.user.user_gender || 'unknown';
                console.log('Found user from window.user:', this.userName, this.userGender);
                return;
            }
            
            // Method 2: Meta tags
            const nameMeta = document.querySelector('meta[name="user-name"], meta[property="user:name"]');
            const genderMeta = document.querySelector('meta[name="user-gender"], meta[property="user:gender"]');
            if (nameMeta) {
                this.userName = nameMeta.content || 'Guest';
                this.userGender = genderMeta ? genderMeta.content : 'unknown';
                console.log('Found user from meta tags:', this.userName, this.userGender);
                return;
            }
            
            // Method 3: Data attributes
            const userElement = document.querySelector('[data-user-name], [data-username]');
            if (userElement) {
                this.userName = userElement.getAttribute('data-user-name') || 
                               userElement.getAttribute('data-username') || 'Guest';
                this.userGender = userElement.getAttribute('data-user-gender') || 'unknown';
                console.log('Found user from data attributes:', this.userName, this.userGender);
                return;
            }
            
            // Method 4: Common selectors
            const nameSelectors = [
                '.user-name', '.username', '.profile-name', '.display-name',
                '[data-username]', '[data-user-name]', '.post-author'
            ];
            
            for (const selector of nameSelectors) {
                const element = document.querySelector(selector);
                if (element) {
                    this.userName = element.textContent?.trim() || 
                                   element.getAttribute('data-username') ||
                                   element.getAttribute('data-user-name') || 'Guest';
                    console.log('Found user from selector', selector, ':', this.userName);
                    break;
                }
            }
            
            console.log('Final detected user:', this.userName, this.userGender);
        } catch (error) {
            console.error('Error detecting user info:', error);
            this.userName = 'Guest';
            this.userGender = 'unknown';
        }
    }

    generateSessionId() {
        return 'chatgpt_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }

    getChatHistory() {
        // Get last 5 messages for context
        const messages = document.querySelectorAll('.chatgpt-message');
        const history = [];
        
        for (let i = 0; i < Math.min(messages.length, 10); i++) {
            const message = messages[i];
            const textElement = message.querySelector('.chatgpt-message-text');
            if (textElement) {
                const sender = message.classList.contains('chatgpt-message-user') ? 'user' : 'bot';
                history.push({
                    sender: sender,
                    text: textElement.textContent.trim()
                });
            }
        }
        
        return history;
    }

    bindEvents() {
        // Toggle chat
        document.getElementById('chatgpt-toggle').addEventListener('click', () => {
            this.toggleChat();
        });

        // Close chat
        document.getElementById('chatgpt-close').addEventListener('click', () => {
            this.closeChat();
        });

        // Minimize chat
        document.getElementById('chatgpt-minimize').addEventListener('click', () => {
            this.minimizeChat();
        });

        // Send message
        document.getElementById('chatgpt-send').addEventListener('click', () => {
            this.sendMessage();
        });

        // Enter key to send
        document.getElementById('chatgpt-input').addEventListener('keypress', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                this.sendMessage();
            }
        });

        // Auto resize textarea
        document.getElementById('chatgpt-input').addEventListener('input', (e) => {
            this.autoResizeTextarea(e.target);
        });
    }

    setWelcomeTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString('vi-VN', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });
        document.getElementById('welcome-time').textContent = timeString;
    }

    async generateWelcomeMessage() {
        try {
            const resp = await fetch('{$system.system_url}/includes/ajax/phuong_nhi.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'generate_welcome', user_name: this.userName })
            });

            const raw = await resp.text(); // <- ĐỌC TEXT
            let data;
            try {
                data = JSON.parse(raw);
            } catch (e) {
                throw new Error('Bad JSON from server: ' + raw.slice(0, 400));
            }

            if (data.success && data.message) {
                const el = document.querySelector('#welcome-message') || document.querySelector('.chatgpt-message-text');
                if (el) el.textContent = data.message;
            } else {
                throw new Error((data && (data.error || data.message)) || 'Unknown error');
            }
        } catch (err) {
            console.error('Welcome error:', err);
            // Giữ UI không crash
        }
    }

    toggleChat() {
        const window = document.getElementById('chatgpt-window');
        const isVisible = window.style.display !== 'none';
        
        if (isVisible) {
            this.closeChat();
        } else {
            this.openChat();
        }
    }

    openChat() {
        document.getElementById('chatgpt-window').style.display = 'flex';
        document.getElementById('chatgpt-input').focus();
        this.scrollToBottom();
    }

    closeChat() {
        document.getElementById('chatgpt-window').style.display = 'none';
    }

    minimizeChat() {
        this.closeChat();
    }

    autoResizeTextarea(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = Math.min(textarea.scrollHeight, 100) + 'px';
    }

    async sendMessage() {
        const input = document.getElementById('chatgpt-input');
        const message = input.value.trim();
        
        if (!message || this.isTyping) return;

        // Add user message
        this.addMessage(message, 'user');
        input.value = '';
        this.autoResizeTextarea(input);

        // Show typing indicator
        this.showTyping();

        try {
            // Send to backend
            const response = await this.sendToBackend(message);
            
            // Hide typing indicator
            this.hideTyping();
            
            // Add bot response
            this.addMessage(response.message, 'bot');
            
        } catch (error) {
            console.error('Chat error:', error);
            console.error('Error details:', error.message);
            this.hideTyping();
            this.addMessage('Xin lỗi, có lỗi xảy ra. Vui lòng thử lại sau. Lỗi: ' + error.message, 'bot');
        }
    }

    addMessage(content, sender) {
        const messagesContainer = document.getElementById('chatgpt-messages');
        const messageDiv = document.createElement('div');
        messageDiv.className = `chatgpt-message chatgpt-message-` + sender;

        const now = new Date();
        const timeString = now.toLocaleTimeString('vi-VN', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });

         const avatarIcon = sender === 'user' ? 'fas fa-user' : 'fas fa-robot';
         let avatarContent;
         if (sender === 'bot') {
             // Sử dụng avatar động của Phương Nhi
             if (this.phuongNhiAvatarUrl) {
                 avatarContent = '<img src="' + this.phuongNhiAvatarUrl + '" alt="Phương Nhi" class="avatar-image" onerror="this.style.display=\'none\'; this.nextElementSibling.style.display=\'flex\';"><i class="' + avatarIcon + '" style="display: none;"></i>';
             } else {
                 // Fallback nếu chưa load được avatar
                 avatarContent = '<img src="/TCSN/Script/content/uploads/photos/2025/09/sngine_fe74c972cc54d5d8a5169d0807eb26c7_cropped.jpg?v=1" alt="Phương Nhi" class="avatar-image" onerror="this.style.display=\'none\'; this.nextElementSibling.style.display=\'flex\';"><i class="' + avatarIcon + '" style="display: none;"></i>';
             }
         } else {
             avatarContent = '<i class="' + avatarIcon + '"></i>';
         }

        messageDiv.innerHTML = 
            '<div class="chatgpt-message-avatar">' +
                avatarContent +
            '</div>' +
            '<div class="chatgpt-message-content">' +
                '<div class="chatgpt-message-text">' + this.escapeHtml(content) + '</div>' +
                '<div class="chatgpt-message-time">' + timeString + '</div>' +
            '</div>';

        messagesContainer.appendChild(messageDiv);
        this.scrollToBottom();
    }

    showTyping() {
        this.isTyping = true;
        document.getElementById('chatgpt-typing').style.display = 'flex';
        document.getElementById('chatgpt-send').disabled = true;
        this.scrollToBottom();
    }

    hideTyping() {
        this.isTyping = false;
        document.getElementById('chatgpt-typing').style.display = 'none';
        document.getElementById('chatgpt-send').disabled = false;
    }

    scrollToBottom() {
        const messagesContainer = document.getElementById('chatgpt-messages');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    async sendToBackend(message) {
        const resp = await fetch('{$system.system_url}/includes/ajax/phuong_nhi.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'send_message',
                message,
                user_name: this.userName,
                chat_history: this.getChatHistory(),
                session_id: this.sessionId
            })
        });

        const raw = await resp.text();
        let data;
        try {
            data = JSON.parse(raw);
        } catch (e) {
            throw new Error('Bad JSON from server: ' + raw.slice(0, 400));
        }

        if (data.success) {
            this.conversationId = data.conversation_id || this.conversationId;
            return data;
        }
        throw new Error(data.error || data.message || 'Unknown error');
    }

    async loadConversation() {
        try {
            const response = await fetch('{$system.system_url}/includes/ajax/phuong_nhi.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'load_conversation',
                    session_id: this.sessionId
                })
            });

            if (response.ok) {
                const data = await response.json();
                if (data.success && data.messages) {
                    this.conversationId = data.conversation_id;
                    this.loadMessages(data.messages);
                }
            }
        } catch (error) {
            console.error('Load conversation error:', error);
        }
    }

    loadMessages(messages) {
        const messagesContainer = document.getElementById('chatgpt-messages');
        messagesContainer.innerHTML = '';

        messages.forEach(msg => {
            this.addMessage(msg.content, msg.sender_type);
        });
    }

     escapeHtml(text) {
         const div = document.createElement('div');
         div.textContent = text;
         return div.innerHTML;
     }

     async getPhuongNhiAvatar() {
         try {
             const response = await fetch('{$system.system_url}/includes/ajax/phuong_nhi.php', {
                 method: 'POST',
                 headers: {
                     'Content-Type': 'application/json',
                 },
                 body: JSON.stringify({
                     action: 'get_avatar'
                 })
             });

             if (response.ok) {
                 const data = await response.json();
                 if (data.success && data.avatar) {
                     this.updatePhuongNhiAvatar(data.avatar);
                 }
             }
         } catch (error) {
             console.error('Error getting Phương Nhi avatar:', error);
         }
     }

     updatePhuongNhiAvatar(avatarPath) {
         if (!avatarPath) return;
         
         const avatarUrl = '{$system.system_url}/content/uploads/' + avatarPath;
         
        // Cập nhật avatar trong toggle button (góc phải)
        const toggleAvatar = document.querySelector('.toggle-avatar');
        if (toggleAvatar) {
            toggleAvatar.src = avatarUrl;
        }
        
        // Cập nhật avatar trong header (icon ngay tên Phương Nhi và Đang hoạt động)
        const headerAvatar = document.querySelector('#header-avatar img');
        if (headerAvatar) {
            headerAvatar.src = avatarUrl;
        }
        
        // Cập nhật avatar trong tin nhắn chào đầu tiên
        const welcomeAvatar = document.querySelector('#welcome-avatar img');
        if (welcomeAvatar) {
            welcomeAvatar.src = avatarUrl;
        }
         
         // Cập nhật avatar trong tất cả tin nhắn hiện tại
         const messageAvatars = document.querySelectorAll('.chatgpt-message-avatar img');
         messageAvatars.forEach(img => {
             if (img.alt === 'Phương Nhi') {
                 img.src = avatarUrl;
             }
         });
         
         // Lưu avatar cho việc thêm tin nhắn mới
         this.phuongNhiAvatarUrl = avatarUrl;
         
         console.log('Avatar updated to:', avatarUrl);
     }
 }

// Initialize Chat GPT Helper when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    new ChatGPTHelper();
});
</script>
