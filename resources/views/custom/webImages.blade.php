<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script type="text/javascript">
	"use strict";
  $(window).on("load", function () {
        var displayNameJob = "importLocalImagesJob";
        var url = "{{ route('check.job.existence', ":displayNameJob") }}";
        url = url.replace(':displayNameJob', displayNameJob);

        $.ajax({
            url: url,
            method: "get",
            success: function (response) {
              if(response == 1){
                $('#uploadPartImagesLocally').addClass('inactiveLink');
                $("#importImagesLocallySpinner").removeClass("d-none");
                $("#importImagesLocallyText").text("Importing");
              }else if(response == 0){
                $("#importImagesLocallySpinner").addClass("d-none");
                $("#importImagesLocallyText").text("Import Images");
                $('#uploadPartImagesLocally').removeClass('inactiveLink');
              }
            }
        });

        $('#errorLogBtn').on('click',function () {
            $('#errorLogModal').modal('show');
            $.ajax({
                type: "get",
                url: "{{ route('webImage.errorLogs') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'part_image_log_id':$(this).attr('data-id'),
                },
                success:function(response) {
                    if (response.success) {
                        $('#errorLogTable').empty();
                        $('#errorLogTable').html(response.code);

                    }
                }
            })

        });
    });
  var KTChartsWidget15 = {
  init: function () {
    !(function () {
      if ("undefined" != typeof am5) {
        var e = document.getElementById("kt_charts_widget_15_chart");
        e &&
          am5.ready(function () {
            var t = am5.Root.new(e);
            t.setThemes([am5themes_Animated.new(t)]);
            var a = t.container.children.push(
                am5xy.XYChart.new(t, {
                  panX: !1,
                  panY: !1,
                  layout: t.verticalLayout,
                })
              ),
              r =
                (a.get("colors"),
                [
                  {
                    country: "All",
                    visits: {{ isset($all) ? $all : ''  }},
                    columnSettings: {
                      fill: am5.color(
                        KTUtil.getCssVariableValue("--bs-primary")
                      ),
                    },
                  },
                  {
                    country: "Def",
                    visits: {{ $def ?? '' }},
                      columnSettings: {
                          fill: am5.color(
                              KTUtil.getCssVariableValue("--bs-primary")
                          ),
                      },
                  },
                    {
                        country: "Alt1",
                        visits: {{ $alt1 ?? '' }},
                        columnSettings: {
                            fill: am5.color(
                                KTUtil.getCssVariableValue("--bs-primary")
                            ),
                        },
                    },
                    {
                        country: "Alt2",
                        visits: {{ isset($alt2) ? $alt2 : ''  }},
                        columnSettings: {
                            fill: am5.color(
                                KTUtil.getCssVariableValue("--bs-primary")
                            ),
                        },
                    },
                    {
                        country: "Alt3",
                        visits: {{ $alt3 ?? '' }},
                        columnSettings: {
                            fill: am5.color(
                                KTUtil.getCssVariableValue("--bs-primary")
                            ),
                        },
                    },
                    {
                        country: "Alt4",
                        visits: {{ isset($alt4) ? $alt4 : ''  }},
                        columnSettings: {
                            fill: am5.color(
                                KTUtil.getCssVariableValue("--bs-primary")
                            ),
                        },
                    },
                    {
                        country: "Alt5",
                        visits: {{ isset($alt5) ? $alt5 : ''  }},
                        columnSettings: {
                            fill: am5.color(
                                KTUtil.getCssVariableValue("--bs-primary")
                            ),
                        },
                    },
                    {
                        country: "Alt6",
                        visits: {{ $alt6 ?? ''}},
                        columnSettings: {
                            fill: am5.color(
                                KTUtil.getCssVariableValue("--bs-primary")
                            ),
                        },
                    },
                    {
                        country: "Alt7",
                        visits: {{ $alt7 ?? '' }},
                        columnSettings: {
                            fill: am5.color(
                                KTUtil.getCssVariableValue("--bs-primary")
                            ),
                        },
                    },
                    {
                        country: "Alt8",
                        visits: {{ isset($alt8) ? $alt8 : ''  }},
                        columnSettings: {
                            fill: am5.color(
                                KTUtil.getCssVariableValue("--bs-primary")
                            ),
                        },
                    },
                    {
                        country: "Alt9",
                        visits: {{ $alt9 ?? '' }},
                        columnSettings: {
                            fill: am5.color(
                                KTUtil.getCssVariableValue("--bs-primary")
                            ),
                        },
                    },
                    {
                        country: "Alt10",
                        visits: {{ $alt10 ?? ''}},
                    columnSettings: {
                      fill: am5.color(
                        KTUtil.getCssVariableValue("--bs-primary")
                      ),
                    },
                  },
                  {
                    country: "Var",
                    visits: {{ $variation ?? ''}},
                    columnSettings: {
                      fill: am5.color(
                        KTUtil.getCssVariableValue("--bs-primary")
                      ),
                    },
                  },
                ]),
              o = a.xAxes.push(
                am5xy.CategoryAxis.new(t, {
                  categoryField: "country",
                  renderer: am5xy.AxisRendererX.new(t, { minGridDistance: 30 }),
                  bullet: function (e, t, a) {
                    return am5xy.AxisBullet.new(e, {
                      location: 0.5,
                      sprite: am5.Picture.new(e, {
                        width: 24,
                        height: 24,
                        centerY: am5.p50,
                        centerX: am5.p50,
                        src: a.dataContext.icon,
                      }),
                    });
                  },
                })
              );
            o
              .get("renderer")
              .labels.template.setAll({
                paddingTop: 20,
                fontWeight: "400",
                fontSize: 13,
                fill: am5.color(KTUtil.getCssVariableValue("--bs-gray-500")),
              }),
              o
                .get("renderer")
                .grid.template.setAll({ disabled: !0, strokeOpacity: 0 }),
              o.data.setAll(r);
            var i = a.yAxes.push(
              am5xy.ValueAxis.new(t, {
                renderer: am5xy.AxisRendererY.new(t, {}),
              })
            );
            i
              .get("renderer")
              .grid.template.setAll({
                stroke: am5.color(KTUtil.getCssVariableValue("--bs-gray-300")),
                strokeWidth: 1,
                strokeOpacity: 1,
                strokeDasharray: [3],
              }),
              i
                .get("renderer")
                .labels.template.setAll({
                  fontWeight: "400",
                  fontSize: 13,
                  fill: am5.color(KTUtil.getCssVariableValue("--bs-gray-500")),
                });
            var s = a.series.push(
              am5xy.ColumnSeries.new(t, {
                xAxis: o,
                yAxis: i,
                valueYField: "visits",
                categoryXField: "country",
              })
            );
            s.columns.template.setAll({
              tooltipText: "{categoryX}: {valueY}",
              tooltipY: 0,
              strokeOpacity: 0,
              templateField: "columnSettings",
            }),
              s.columns.template.setAll({
                strokeOpacity: 0,
                cornerRadiusBR: 0,
                cornerRadiusTR: 6,
                cornerRadiusBL: 0,
                cornerRadiusTL: 6,
              }),
              s.data.setAll(r),
              s.appear(),
              a.appear(1e3, 100);
          });
      }
    })();
  },
};
"undefined" != typeof module && (module.exports = KTChartsWidget15),
  KTUtil.onDOMContentLoaded(function () {
    KTChartsWidget15.init();
  });


Dropzone.autoDiscover = false;

$("#import_batch_image").dropzone({
    autoProcessQueue: false,
    addRemoveLinks: true,
    maxFiles: 50,
    uploadMultiple: true,
    parallelUploads: 50,
    acceptedFiles: ".jpg, .jpeg",
    method: "POST",
    dataType: "json",
    url : "{{route('import.images.batch')}}",
    data :{
        _token : "{{csrf_token()}}"
    },
    init: function () {

    var myDropzone = this;

    // Update selector to match your button
    $("#button_store_image").click(function (e) {
        e.preventDefault();
        myDropzone.processQueue();
        const acceptedFiles = myDropzone.getAcceptedFiles().length;
        if(acceptedFiles == 0){
         toastr.error('Please Add Images To Continue');
         return false;
        }else{
         toastr.success('Import Started Successfully');
         $('#uploadPartImagesLocally').addClass('inactiveLink');
         $("#importImagesLocallySpinner").removeClass("d-none");
         $("#importImagesLocallyText").text("Importing");
        }
      
    });

    this.on('sending', function(file, xhr, formData) {
    // Append all form inputs to the formData Dropzone will POST
    var data = $('#import_batch_image').serializeArray();
      $.each(data, function(key, el) {
          formData.append(el.name, el.value);
      });

    });
    },
    success:function(response){


      Dropzone.forElement('#import_batch_image').removeAllFiles(true);
      $("#uploadImageBatch").modal("hide");
      LocalImportStstus();
      if(response.success == true){
        toastr.success(response.msg);
      }else if(response.success == false){
        toastr.error(response.msg);
      }
    }

});

const LocalImportStstus = () =>{
  var displayNameJob = "importLocalImagesJob";

        var url = "{{ route('check.job.existence', ":displayNameJob") }}";
        url = url.replace(':displayNameJob', displayNameJob);

        $.ajax({
            url: url,
            method: "get",
            success: function (response) {
              window.StatusLocalImport = response;
              if( window.StatusLocalImport == 1){
                setTimeout(() => {
                  LocalImportStstus();
                }, 2000);
              }else if(window.StatusLocalImport == 0){
                  $("#importImagesLocallySpinner").addClass("d-none");
                  $("#importImagesLocallyText").text("Import Images");
                  $('#uploadPartImagesLocally').removeClass('inactiveLink');
              }
            }
        });


};
//update Error Log image
    const updateErrorImage=(thisElement)=>{
        const rowId = event['srcElement']['attributes']['data-id']['nodeValue'];
        const folderName = event['srcElement']['attributes']['data-folder_name']['nodeValue'];
        const imageName = $(thisElement).closest('tr').find('.errorWebImage').val();
       let url = "{{ route('updateError.webImage', [":rowId",":folderName",":imageName"]) }}";
        url = url.replace(':rowId', rowId).replace(':folderName', folderName).replace(':imageName', imageName);
        $.ajax({
            url: url,
            method: "get",
            beforeSend: function(){
                $('#loaderModal').modal('show');
            },
            success: function (response) {
                $('.modal').modal('hide');
                if(response.success=="true"){
                toastr.success(response.msg);

                }else{
                    toastr.error(response.msg);

                }
            }
        });

    }

// delete error image from web images
const delteErrorImage = () =>{
  const rowId = event['srcElement']['attributes']['data-id']['nodeValue'];
  const folderName = event['srcElement']['attributes']['data-folder_name']['nodeValue'];
  const imageName = event['srcElement']['attributes']['data-image']['nodeValue'];
  let url = "{{ route('delete.webImabge', [":rowId",":folderName",":imageName"]) }}";
  url = url.replace(':rowId', rowId).replace(':folderName', folderName).replace(':imageName', imageName);
  $.ajax({
    url: url,
    method: "get",
    success: function (response) {
     toastr.success(response.msg);
     document.getElementById("errorLogTable").deleteRow(document.getElementById("errorLogTable").rowIndex);
    //  after deleting updating front view
     $("#webImagesTotalUploads").text(parseInt($("#webImagesTotalUploads").html()) -1);
     $("#webImagesCompleted").text(parseInt($("#webImagesTotalUploads").html()) +1);
     $("#webImagesError").text($("#webImagesError").html()-1);

    }
  });
};
// on change of batch fetch data and update view
$(".batchwebImagesImport").click(function(){
  const batchNo = event['srcElement']['attributes']['data-id']['nodeValue'];
  let url = "{{route('fetch.batch',":batchNo")}}";
  url = url.replace(":batchNo", batchNo);
  $.ajax({
    url: url,
    method: "get",
    success: function (response) {
      if(response.success == false){
        $("#webImagesTotalUploads").text(0);
        $("#webImagesCompleted").text(0);
        $("#webImagesError").text(0);
        $("#webImagesVariations").text(0);
        toastr.error(response.msg);
      }else{
        $("#webImagesTotalUploads").text(response['data']['total_images']);
        $("#webImagesCompleted").text(response['data']['successfully_processed_images']);
        $("#webImagesError").text(response['data']['error_logged_images']);
        $("#webImagesVariations").text(response['data']['variation_images']);
      }
    }
  });
});

</script>
