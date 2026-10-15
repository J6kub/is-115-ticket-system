async function FetchiniGoosini(filter = null, fv = null) {
    url = "./GetTickets.php?";
    if (filter != null) {
        url += `${filter}=${fv}`;
    }
    

    const res = await fetch(url);
    if (res.status == 200) {
        data = await res.json();
    } else {
        data = null
    }
    
    return data
}
const searchy_filter = document.getElementById("searchy_filter");
const searchy = document.getElementById("searchy_filter");
function setActiveFilter(nf, to) {
    searchy_filter.value = nf;

    const butts = Array.from(document.getElementsByClassName("search-filter"));
    butts.forEach((butt) => {butt.className = "search-filter"})
    to.className += " active";
}

const teeBodi = document.getElementById('teeBodi');
function updateTicketList(ticketList) {
    html = "";
    ticketList.forEach((t)=>{html += ticketToHtml(t)});
    
    teeBodi.innerHTML = html;
}
function ticketToHtml(ticket) {
    return `<tr onclick='location.href="../ticket-view/index.php?id=${ticket.id}"'>
                <td>${ticket.id}</td>
                <td>${ticket.case_name}</td>
                <td>${ticket.FullName}</td>
                <td>${ticket.updated_at}</td>
                <td><span class="status ${ticket.Status}">${ticket.Status}</span></td>
            </tr>`
}


async function MayTheSearchBarCallThis(val) {
    const res = await FetchiniGoosini(filter = searchy_filter.value,fv = val);
    if (res != null) {
        updateTicketList(res.data.results);
    } else {
        teeBodi.innerHTML = ticketToHtml({"id":"No permission", "case_name":".","FullName":"Rawr","updated_at":".", "Status":"."})
    }
    
}