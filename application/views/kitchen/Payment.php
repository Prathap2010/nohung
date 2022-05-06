<style>
    .validation-msg {
        font-weight: normal !important;
        font-size: 13px !important;
        color: red !important;
    }
</style>
<script>
    var PER_PAGE_TRANSACTION = '<?=PER_PAGE_TRANSACTION?>';
</script>
<div class="offerManagementWrap kitchen-payment">
    <div class="offermanageTopHeading">
        <h2>Payment</h2>
        <!-- <a href=""> <img src="assets/images/OfferManagement_icons.svg" alt=""> Add Offer</a> -->
    </div>
    <div class="row">
        <div class="col-lg-3">

            <div class="CreatePackageSection">
                <ul>
                    <li>
                        <div class="weeklyPackage">
                            <span>Total Earnings<br />
                            <p>₹<?=number_format($total_earning,2,'.',',')?></p>
                        </div>
                    </li>
                    <li>
                        <img src="<?= KITCHEN_IMAGES_URL?>payment-art.svg">
                    </li>
                    <li style="margin-bottom: 0px;">
                        <a href="" data-toggle="modal" data-target="#accountModal" data-whatever="@mdo1" onclick="openaddaccountmodal()">Add account Details</a>
                    </li>
                    <?php if($account_available == 1){ ?>
                        <li style="margin-bottom: 0px;">
                            <a href="" data-toggle="modal" data-target="#withdrawModal" data-whatever="@mdo" onclick="openwithdrawmodal()">Withdraw Amount</a>
                        </li>
                    <?php } ?>
                    
                    <li style="margin-bottom: 0px; padding: 0;">
                        <p class="red-note">If account details are added, then it will show 'Withdraw Amount' button</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="managementTabSection">
                <div class="tabContentManagement">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#transaction-history" role="tab">Transaction History</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#wallet-history" role="tab">Wallet Redemption History</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="transaction-history" role="tabpanel">
                        <div class="orderManagementCotents">
                            <div class="row" id="transactionlist">
                            </div>
                            <div class="load_more_btn" style="display:none;">
                                <a href="javascript:void(0)" onclick="load_transaction_history()">load more</a>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="wallet-history" role="tabpanel">
                        <div class="wallet-history-table">
                            <div class="table-responsive">
                                <table id="wallettable" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th class="text-right">Amount Withdrawn (₹)</th>
                                            <th class="text-center">Withdrawal Date & Time</th>
                                            <th class="text-right">Balance Amount (₹)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($walletdata)){ 
                                            foreach($walletdata as $i=>$wallet){ ?>
                                                <tr>
                                                    <td><?=($i+1)?></td>
                                                    <td class="text-right"><?=number_format($wallet['amount'],2,'.',',')?></td>
                                                    <td class="text-center"><?=date("d-m-Y h:i A", strtotime($wallet['createddate']))?></td>
                                                    <td class="text-right bal-amt"><?=number_format($wallet['wallet_amount'],2,'.',',')?></td>
                                                </tr>
                                            <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<div class="modal pay-modal fade" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="withdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="withdrawModalLabel">Withdraw Amount</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="withdrawalform">
            <div class="form-group">
              <label for="withdrawal-amount" class="col-form-label">Current Balance:</label>
              <span>₹<?=number_format($kitchen_wallet,2,'.',',')?></span>
            </div>
            <p id="withdrawal-form-error" class="validation-msg"></p>
            <div class="form-group">
              <label for="withdrawal_amount" class="col-form-label">Withdrawal Amount:</label>
              <input type="text" class="form-control" id="withdrawal_amount" name="withdrawal_amount">
              <span id="withdrawal_amount_error" class="validation-msg"></span>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="send_withdrawal_request()">Send message</button>
        </div>
      </div>
    </div>
</div>

<div class="modal pay-modal fade" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="accountModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="accountModalLabel1">Add Account Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="addaccountform">
            <p id="form-error" class="validation-msg"></p>
            <div class="form-group">
                <label for="account_name" class="col-form-label">Name on Account :</label>
                <input type="text" class="form-control" id="account_name" name="account_name">
                <span id="account_name_error" class="validation-msg"></span>
            </div>
            <div class="form-group">
                <label for="bank_name" class="col-form-label">Bank :</label>
                <input type="text" class="form-control" id="bank_name" name="bank_name">
                <span id="bank_name_error" class="validation-msg"></span>
            </div>
            <div class="form-group">
                <label for="ifsc" class="col-form-label">IFSC Code :</label>
                <input type="text" class="form-control" id="ifsc" name="ifsc">
                <span id="ifsc_error" class="validation-msg"></span>
            </div>
            <div class="form-group">
                <label for="account_number" class="col-form-label">Account Number :</label>
                <input type="text" class="form-control" id="account_number" name="account_number" onkeypress="return isNumeric(event)">
                <span id="account_number_error" class="validation-msg"></span>
            </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="save_account_detail()">Save Details</button>
        </div>
        </div>
    </div>
</div>

<script>
    $('#withdrawModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })
</script>
<script>
    $('#accountModal').on('shown.bs.modal', function () {
        $('#myInput').trigger('focus')
    })
</script>