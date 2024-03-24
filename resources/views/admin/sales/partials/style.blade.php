<style>
    .product-img img {
        width: 90px;
    }

    .product-text-area p {
        font-size: 12px;
    }

    /* .product-list-wrapper {
         text-align: center
         } */

    .product-info__content .fs-6 {
        font-size: 12px;
    }

    .productListContainer .col-4:hover {
        border: 1px solid #999;

    }

    .home-details-btn-wrapper {
        display: block;

    }


    #loader {
        display: none;
    }

    .input-group-btn {
        display: flex;
        flex-direction: column;
    }

    .btn {
        cursor: pointer;
    }

    .quantitybox input {
        width: 10px !important;
    }

    @keyframes spinner-grow {
        0% {
            transform: scale(0);
        }

        25% {
            opacity: 1;
            transform: none;
        }

        50% {
            opacity: 1;
            transform: scale(0);
        }

        75% {
            opacity: 1;
            transform: none;
        }
    }



    .ribbon-wrapper {
        position: absolute;
        top: 0;
        right: 0;
    }

    .ribbon {
        position: relative;
        background-color: #ff0000;
        /* Ribbon background color */
        color: #ffffff;
        /* Ribbon text color */
        padding: 44px;
        transform: rotate(45deg);
        top: 30px;
        right: -90px;
        /* Adjust this value as needed */
        z-index: 1;
    }

    .ribbon span {
        display: block;
        font-size: 8px;
        /* Adjust font size as needed */
        text-align: center;
        transform: rotate(-0deg);
    }

    select#per_page {
        height: 25px !important;
        margin-left: 8px
    }

</style>
