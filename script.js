$(function() {
    $.ajax({
        url: "list.php",
        success: result => {
            result.forEach((station) => {
                $("#fm_id").append(`<option value="${station.id}">${station.name}</option>`);
            });
            $("#loader_list").addClass("hide");
            $("#fm_id").removeClass("hide");
        },
        error: () => {
            $("#loader_list").html("Błąd podczas łączenia z serwerem");
        }
    });
    $("#fm_id").change(() => {
        $("#loader_station").removeClass("hide");
        $("#window").html("");
        $("#links").html("");
        $("#audio").attr("src", "").addClass("d-none");
        $("#error-container").html("");
        $.ajax({
            url: `ajax.php?id=${$("#fm_id").val()}`,
            success: result => {
                if (!result.success) {
                    $("#error-container").html(result.error);
                    return false;
                }
                $("#audio").attr("src", result.streams[0]).removeClass("d-none");
                $("#links").append(`<h6>${result.music}</h6><h4>Linki do streamów:</h4>`);
                for (id in result.streams)
                    $("#links").append(`<div>
                        <a href="${result.streams[id]}" target="_blank">${result.streams[id]}</a>
                    </div>`);
                for (id in result.yt)
                    $("#window").append(`<div>
                        <h2>${result.yt[id].title}</h2>
                        <img src="${result.yt[id].img}" />
                        <div>Długość: ${result.yt[id].time}</div>
                        <div>${result.yt[id].count} wyświetleń</div>
                        <div>
                            <a href="${result.yt[id].url}" target="_blank">${result.yt[id].url}</a>
                        </div>
                    </div>`);
            },
            error: () => {
                $("#error-container").html("Błąd podczas łączenia z serwerem");
            },
            complete: () => {
                $("#loader_station").addClass("hide");
            }
        });
    });
});
