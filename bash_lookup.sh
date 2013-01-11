#
# Does a reverse lookup of all domains registered on the same Norid-handle as the given domain
#

# you would probably want to put this in your .bashrc
function rnoridwhois() {
    whois $(whois $1 | grep "NORID Handle" | tail -1 | sed 's/.*\.\.: //') \
        | grep Domains \
        | sed 's/.*\.\.: //' \
        | sed 's/ /\n/g' \
        | sort
}

# example usage:

rnoridwhois db.no

