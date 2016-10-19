<style type="text/css">
    @font-face {
        font-family: review;
        font-style: normal;
        font-weight: bold;
        src: url("/fonts/Review.ttf");
    }
    #watermark {
        position: fixed;
        bottom: 0px;
        right: 0px;
        width: 100%;
        height: 100%;
        opacity: .2;
        z-index: 1;
        text-align: center;
    }
    #watermark-text {
        color: #ccc;
        font-size: 90px;
        margin-top: -90px;
        position: relative;
        top: 50%;
        transform: rotate(-45deg);
        text-align: center;
    }

    .logo-container {
        text-align: right;
    }
    .logo-container, .school-container {
        display: inline-block;
        padding: 0px;
        box-sizing: content-box;
    }
    .school-container .school-name {
        font-family: review;
        font-weight: bold;
        color: #333333;
    }
    .school-logo {
        width: 150px;
        height: 130px;
    }

    .header-table {
        width: 100%;
        border: 0px;
    }
    .school-name {
        margin-bottom: 5px;
    }
    .school-phone {
        margin-top: 5px;
    }
    .report-name {
        margin-top: 15px;
        font-size: 21px;
    }
    p { page-break-after: always; }
    .footer {
        position: fixed;
        bottom: 15px;
        right: 15px;
    }
    .pagenum:before {
        content: counter(page);
    }
    .tr h4, .tr h3 {
        vertical-align:middle;
    }
    .pdf-page-break {
        page-break-after: always;
    }
</style>
