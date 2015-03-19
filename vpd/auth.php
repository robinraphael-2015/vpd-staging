<!--#INCLUDE FILE=”simlib.asp”-->
<FORM METHOD=POST ACTION= "https://secure.authorize.net/gateway/
transact.dll">
<!--ret = InsertFP (67x5CmHn, sequence, 114, 5fJv6uLb4KQ7U22Z) -->
<INPUT TYPE=HIDDEN NAME="x_version" VALUE="3.1">
<INPUT TYPE=HIDDEN NAME="x_login" VALUE="67x5CmHn">
<INPUT TYPE=HIDDEN NAME="x_show_form" VALUE="PAYMENT_FORM">
<INPUT TYPE=HIDDEN NAME="x_type" VALUE="AUTH_ONLY">
<INPUT TYPE=HIDDEN NAME="x_trans_id" VALUE="5fJv6uLb4KQ7U22Z">
<INPUT TYPE=HIDDEN NAME="x_method" VALUE="CC">
<INPUT TYPE=HIDDEN NAME="x_amount" VALUE="9.95">
<INPUT TYPE=SUBMIT VALUE="Click here for the secure payment form">
</FORM>