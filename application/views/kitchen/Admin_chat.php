<style>
    .heading {
        padding: 10px 16px 10px 15px;
        margin: 0;
        height: 60px;
        width: 100%;
        background-color: #eee;
        z-index: 1000;
    }

    .heading-avatar {
        padding: 0;
        cursor: pointer;

    }

    .heading-avatar-icon img {
        border-radius: 50%;
        height: 40px;
        width: 40px;
    }

    .heading-name {
        padding: 0 !important;
        cursor: pointer;
    }

    .heading-name-meta {
        font-weight: 700;
        font-size: 100%;
        padding: 5px;
        padding-bottom: 0;
        text-align: left;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #000;
        display: block;
    }

    .heading-online {
        display: none;
        padding: 0 5px;
        font-size: 12px;
        color: #93918f;
    }

    .heading-compose {
        padding: 0;
    }

    .heading-compose i {
        text-align: center;
        padding: 5px;
        color: #93918f;
        cursor: pointer;
    }

    .heading-dot {
        padding: 0;
        margin-left: 10px;
    }

    .heading-dot i {
        text-align: right;
        padding: 5px;
        color: #93918f;
        cursor: pointer;
    }
</style>
<div class="noMenuAddedSection">
    <h2>Messages</h2>
    <div class="messaging">
        <div class="inbox_msg">
            <div class="inbox_people">
                <div class="headind_srch">
                    <div class="recent_heading">
                        <h4>Recent</h4>
                    </div>
                </div>
                <div class="inbox_chat" id="adminlist">

                </div>
            </div>
            <div class="mesgs">
                <div class="msg_history" id="chat_conversation">
                </div>
                <div class="type_msg" style="display: none;">
                    <div class="input_msg_write">
                        <input type="text" id="message" class="write_msg" placeholder="Type a message" />
                        <button class="msg_send_btn" type="button">
                            <img src="<?= KITCHEN_IMAGES_URL ?>paper-plane.png">
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>