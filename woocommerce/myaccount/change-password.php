<div class="changepass form-doimatkhau">
    <form action="" id="f-change-password" class="is-loading-group">
        <div class="form-list row">
            <div class="form-ip col"> <span class="text"><?php _e('Old password', 'monamedia'); ?></span>
                <div class="input">
                    <input type="Old password" placeholder="Password" name="current-password" required><i class="seepassJS fas fa-eye"></i>
                </div>
            </div>
            <div class="form-ip col"> <span class="text"><?php _e('New password', 'monamedia'); ?></span>
                <div class="input">
                    <input type="New password" placeholder="Password" name="new-pass" required><i class="seepassJS fas fa-eye"></i>
                </div>
            </div>
            <div class="form-ip col"> <span class="text"><?php _e('Re-enter new password', 'monamedia'); ?></span>
                <div class="input">
                    <input type="Reconfirm password" placeholder="Password" name="new-repass" required><i class="seepassJS fas fa-eye"></i>
                </div>
            </div>
        </div>
        <button class="btn noic" type="submit"><span class="txt"><?php _e('Change Information', 'monamedia'); ?></span></button>
    </form>
</div>