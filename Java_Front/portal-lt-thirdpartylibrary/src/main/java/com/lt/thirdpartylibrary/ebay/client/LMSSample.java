/**
 * This program is licensed under the terms of the eBay Common Development and
 * Distribution License (CDDL) Version 1.0 (the "License") and any subsequent
 * version thereof released by eBay.  The then-current version of the License
 * can be found at http://www.opensource.org/licenses/cddl1.php
 */

package com.lt.thirdpartylibrary.ebay.client;

import java.util.logging.Logger;

/**
 *
 * @author zhuyang
 */
public class LMSSample {

    private static final String[] commandArray = {
        "UploadJobEnd2End", "UploadFile", "DownloadFile",
        "getJobs", "abortJob", "createUploadJob",
        "startUploadJob", "getJobStatus", "startDownloadJob",
        "DownloadJobEnd2End"};
    private static Logger logger = Logger.getLogger("LMSSample.logger");
    /*
     * main entry point of the program
     *
     */

    public LMSSample() {
    }

    public static void main(String args[]) throws Exception {

        if (args.length < 1) {
            // if no parameters are given, then it print out the description of available commands
            System.out.println(printUsage());
            return;
        }
        String action = args[0];

        int actionCode = 0;
        for (int i = 0; i < commandArray.length; i++) {
            if (commandArray[i].equalsIgnoreCase(action)) {
                actionCode = i;
                logger.config("The command argument===> action command=" + action + " |||||  actionCode =" + actionCode);
            }
        }
        //store id = 1
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**e34yVA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wDkoeoDJWEpg2dj6x9nY+seQ**v88BAA**AAMAAA**YKO+e4Uz2Tmh4SCq0xnDja5EA8I5RkhA/+35gvuMhdVSYhxNZ0W3wSMsW+oxyWp8VdEZRTQnCE4DzyELBBC/1HG9+WL9h+rgnuSYH7gYceyskzIaft2v6InyqxDXcnT4MVbKUTCXNDrHDdevED9eBso1ybjCtg8lzL8kf1H37ocZ8Zr6aAL57OHvCjQtlqyilpGi+/400OBO8Z6omFopw8mklcefmIaY6tDzRf8LqarD5os8eH6hZr/LmyVu9cDsmY1vsNRXQeneDfnKDO1jbdDfDkWuSQQPUqpE5A5n4nPIZMAd8MCDE5+Q/06I8ToEO+lraVU+r6PMGE8WLy6dWU//V/a+yYkQoYguIRvsXuz1VC83/h5gwjJuXNaXqk1moucZSgd8Ew1ojuncPcfDGjMsYs/u4Cl0wdTyn7goshm7eSD8lPMVJBrBpvlqNc5Zl5HgUDboWnK3Z2ZDoIRY0sMP009gG4ZV3VdbYaADV9pzV+UkUTXbDNsBkf6MKQulgrrMZ53wEFWErV6+3e0uWQbJKdkcHM1E4MkumNXrrG0xMavm0p3Rp5/Br8CxZ83rIfD0EFE0shxJAezGMZ0jFCyFuF2Oa+6nAhbLdB/teYI9juBP4/s7B9nnofvX2gM5Ye2woPen4yUmAKln3hcoUuIUVT5xKJ6esxZ6pVXAbui6Xh1iuellzdky8dBzlsfCmwplwsklTYyWMcBE5QNwN1knYorvbbc/qmEe2+ltWeeLZNZ+jE4MqZynBrwdUVwn";
        //store id = 2
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**UIUyVA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wMkoWgAJmLoAqdj6x9nY+seQ**yc8BAA**AAMAAA**yv35URRo2jxyfgeVKqwP07WNMqmtSgn1AZ7a8b07iMfg/ek4+GgR9hRRkDO119OSYFiLZgSfkpYR4eyWthTNDW/BO5tKUSqXiWl64xcQB4nXPiukI7qH25b/fZN7Hnc+9REhS1petKICMAga9dsFZbzknPTvE7XFj6tFUdYMgUJbM5ZyYWTEWDcK+kktlekYK97csJIsloqBuYZ9uNo2c68bSdiiUDB7KCHQFlhnmLRJF5+7zeWgKNSuJRqz9SWnDsE1zmBps1y1MjBHJHMRDrObqNIT80/7ETOxAIqBPpQ7PaH9Xm/mMJpay6rXPd2fjJrRsLSwHfYToq5uxWUySfjTHTchUkVm6lFAPZAjSoRM/2wNz8DUlnRf5Ci6jJfg79ke5EMUBSJZuuYuVvrSQxtqb+aoNLmtXyK1TtIAbBnB6aQ5yyXHYim5xPUl9gzwKN4wuDbHOQNxTMypiNhdiGKyuARQbQLhJ4kl8WYY5vtyaMcrVkAolyl8BskMem6AyXsR+7nLzOaZh4AdTRXgqghr0Ep7cLwR/CtbUmH6ogzcvj9HvTd0qBdmC2B7N2iJGh562EQxCqRfBXwbu82026C2DHFdq9ZmcnhOSCftgWBxaRSYnIHBxDuVtq+nfHhgsDos949wFk3zLm+0OEL7uocqaKU6NDycmmc5MeBMtPJSJU8BShgS2U70sAEbfFOa2OggqAC2z+beubfix30iI2qnP7PcrmeBRFY4sx+ZYphOjI3Tz0kSvULGHnXi2oRe";
        //store id = 4
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**wycBVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AFkoWjC5GKpg+dj6x9nY+seQ**qoUBAA**AAMAAA**WcUBL+lraz1wpkJC3A2CS7G4+YQTp2QbWJnqeckC66h7NviIL0JS4FNq+1VnQ1K+yHD1NbXBCp72OUcQ6Wigj1HcXN63B/5mLWgPPL6lNqPcFT6XQEFBrvIKZSApS0fsqsDiowOY7oU8VzKY+doYqcWSNsQjzuwr0XVtBlYk/v3NS0LKe5J5Wfvq6R6oXBdTBb1/GL7lps9KOhtTUUiVZtJoP49ovxDkcygMoAa49l5Dzl3lYs1D4HVb3TxgFKTrI7p9xZUS/Ao+7A93Na9iBtKZPsYB4nwsJNBG3bvXE5mLgRLE9aiZp4CAf8/0hyqvy6UUUezcdQfa+nNCFy7skJyaCgNcbRQjFqUa6dxaEVe4whdTcXPBiGzNlHfQvzOJzqdacjhssqwyZGHw4zfxTKSlMbA0LhYu6Ofme3UkLRqKnUSLQ2nOTpfeyqXfCUlBdypeQyQO8iVSlRVlwj+ArXrh8Tl4BiJYLQabiDW7FUm1jnMbuP7wNIt5zuWHWsWQ0IyPNYdC5RGaeo2NftdGulhGbLJvWg3nI6veo77e01Z8QRwWI74ORCdRu3xJ791YH6o/JfSaoiSNtK0tGXf8w0QBFAP2CWvq//408bVCTidYeiLVYY8WokQaNVJtRE1pBWl+XbKOYz7Fh2El9tDHoB7YfaCXMjJGSqVXYfF97/sctAnoYS9m4p+doL9Cx+PIY3tXBA+KM1SZL1Tp/9TsE30qkBJj+ZcmLFDg5+OuXURflwRwoiI8RB1CVcN2Pptc";
        //store id = 5
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**PygBVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AFkoanCJOKpASdj6x9nY+seQ**qoUBAA**AAMAAA**xg882xs53Hwrr3tu4Gh7+6FEYB29oPHruSyMZD9EUkGOMpnyUTDxI0y5f21vKHrmptpowk/rt/wEzRz5nxBtn2mFTy3yfMIo1mkduE4oQr6oWqNdWBiOzAjhx7Ieqav7L7W7HEW3kMkHZciCfLmeA02cYR/BRJIBz7wRj6LJG6czvM2K/BxGDz0KkI/MwyJLobH3mXh5VLLX09UtLybWCImpXQinaB8b1B+XW6xxZaNai4GXQ/x3Z1DmhIz3xjKMJbKdSnsbJOlKQTVzPATSMXI46WAajnyd/L4JBS2Yj/H8vxhQPExy6/NkZJCg7T26/4VwODrEMb85XLeE750RW1YoPYQNxOaHupH1cYlfZ0hvEqe4GIsRIk5cwi5RUPbfUjo0aVnBVdmUF3odcdupEJCwRzC8i92osooDN5oz3iFKS4iNTlw71EkfxMc/JHZhCEYEI9/7DA9MnOz4oxl/7UjTSKoNd5HG0uDizQathfAukmgPPA8+7lQ+dHkftM8lq3FS0aGcjJw4lROEl61XmLzHu363oaePXBmoUaUnMYs7RDjfCetWWEshjQtDVyMYzO1yDpKRhGv7BdscBX+2h5P23EdHElw4Fg4tF7Oi3O/q/lbR3CYwxKqloai/JeOCwQ38QsDE55K3NkZwbyq/bafB7ymyOypyIQz3cKdt486kbg2ShJGbh6jEysKAa3xK+KvFBpyZYhCb5eNajnzuOr7mUGfeva8QKRiF+ueBYoOvlIoGLj1prwYKtxu4tmEZ";
        //store id = 6
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**fSgBVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AFkoWiCpaBpgqdj6x9nY+seQ**qoUBAA**AAMAAA**1KYmvbNEt2U1rUSwmasLrcdYAVeyDXJ+AOb1mwwRJjGWdFNL5l9LuVPRKgKbVQFuMIUSKC1mhDkOYwgvZyP4kFff1hryHtGpTEIAIfrRF5MNBxiH0WNfAiZDFbm8irwFbv5cJkpRI+8p+4UG3Mfv8SfbfEKdxNvp5eBpfWrhZt9MCj0R3GGrR68FgnYUU+fKNd0vpib4uPh74NPqGPCC+s3Y6oxclgf5rfn5xXiJIk7MNK7vRvJ2ICZwLtFFuPD3TDRyqp8XQxug0AO2MyOS7iKq4w9nDcdBS0uVBj/U67nXRIimpVLBVMJI3oHoL/fynVumopQQa1TMn3syKH+sbYrjjrogs9nhwrWvcjJtH4lfsJb6Bse9JtO0jKG1KyTTL0ujlvyR3Rm+PQZOIY69/iz5Ys7rvGBcDuOc4UVC3B1A8GNC5e+/AbApDpYxeojsUuJ7AYMcRU1n7dIM70I6K0LHko+xJzinrZ7OEeL7fXslu96l6uC+wy83vZJKOhep4cPaxgolkbjQn04psOGEcrmUNK6baG94q4N5umIayVGpTNeh4tug9cWPbQf2v9QKbe+bTR4cp79a2GrSK5+i2r4JM5orJFAPeR3metaH6/GOKi5Iqz+DEDanV7fCkd6oEYvhAJGjxpbfpszkT1EKQRScAps9F8zM9FrwStVPsr9Xs5+l5HthpZ1WAzRzMnE9zx/6lrazMOv1E4bNCe+HpNfGtM4fH3+yME6aLuxi3upiGVdJatOXoxSmNsz46sj4";
        //store id = 7
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**zigBVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AFkoakAJmGqAidj6x9nY+seQ**qoUBAA**AAMAAA**Q+JzK6ryZbEwT36WZqFw9geg34+k5Z7ke+qCkfMmE/K7h+RyZNMccHmPYIZ8en+pzdF5WtyypAEVb+XkXpu5nD2u456C/tUUvQRpxEM+u0gLnOGmkE1MQBdXy0G1p13A7PcIKvGdfqQW8HQsTvhqygQtJQ303Cg089SjM4nqeMqpFRX2Da+a1SOKqX5LD8ebfu3lvDXdyD1bkUEqK3c7/tVCaOdgFT4dnym9JXOXeYhqqjFU9S0nUkaVOu7rAul68TMlFvnQtif/6tF2azJ+zbnEz9+jpuJkinVVsi6Phdce536WWtIjXch6XD3cq6y/G8313uPV2PIO3mSuDRmSy9T6wpRenx0GSBrCFvbAuaM9a4jX0wDMxk99QTThvCIHgR3FVlvEC/g9Ib1mYTs9WmPbL6v/OaGpReRfnRMUpoWe0oXxwp5WfVPGLRGVwAESZLKNWdyZ7TwNeFs+OmU4rGx6iINVuHtq8xqEsA6LQt0Z73qlJXBhy0t1xFOkKlVmWEd3kXma9EPSKhRShaj/YW9XkUrEHP41HselrkSwjIHPjg/EWjGhTXS8ZrI5Wiw+uG7LY1F0DAnEZqrB684dsqvFreQHBGTdlWiwVQ3OqFuLDRNygvnl0qwo5hAmyeGfNs1HbGtvnCSn/P5YzxCKHIljckQ2jzhzaCYSoOt9j1xsvRJq6+w830g4WG4k2tf7i+rqXdDn3VQ8gqglLBvzZ20dH54XrE1PkGHKjntt+rdmiRt7qVrVLKlS47lLdlAD";
        // store id = 18
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**iJwGVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEkoOpDJWEpw6dj6x9nY+seQ**SMECAA**AAMAAA**2FftFpAQHLh6CduQS8RSe9Q/cy1bMY4qfANSKEDUjr6EKk5JxDRtPlgjKuzI/zCE71F79CpWGT1oPvezVmoPuyGqfFdTLtXtqG6qYG01pDZ1wY2ExquYprZY4fwUhEK8FiabCngDj8wJXZPj0cEGBPc93dYZgUZ+csMJw8ZncBii/tgAisp0/lI3k+ogRgyDukny0izntDbTDcMzQo/oBuX5syRqeNtDzW0hYizm+ivs/GzwwnYsoH6EscSfh9Wc1jEIhBbeUCdedGNo1F+0dcvdshF4dJ+OSHsDwci5F3EFeQAUSlG319bV5tQVbJTkAzcxstzU/r7E+alDwq34eSYf8fTWXWhhOUzqXnjU/UVGDUtVKRDYE1m4zoqUuLWKxm4kFDwFlcMo3sXbUE/O33U9ZlUXtDdlwvfaJTWOdfBw+BxHcP3eIFMsKfvtHSze6Maly/k/5yoFaFjqCJFVHl4plD1/ar/9EXNPgIs5Ii92Onxr56Hus0E9NQHNLMtbG9A9fIlvCkPtLuzmtURGTohbq5pyXtZtyTZdH0de62b0cmaiSVO7Wrg23adj9GrVoiktCirDFmcic00SnzPwpPSX3zm/YMEzQ5meYSv4zcEvxNa1YF2k3xOalQcFza8DT73iw948mXC54rc0Cjja/XFeYPU1Jg/AVvGj9tb+OhMZeQl/GYd8ndh11O+KinnE0eneg374Fj87kfWAuXRTtm4P+2CP6vbD8qTS8CG/ieb2SmvgDRpuSm7CCLJ0p1bC";
        // store id = 19
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**LKUTVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AElIqjD5mDowqdj6x9nY+seQ**SMECAA**AAMAAA**NvLa4oxirjblxkKtrwrLSp3J+RK2s8ctVLvrG/4d2hBSe0SoGetKMMbR9YI1hYyaox2MhD9htO9SdSMlup80UFoa0n4ix+IR8paewAXNoQuTG0upkew49tMB7v26G9JtCNtLr+34lrMQII+e34lo/XN5YCH53/FyG8fbHPYCIzKC7UkHMc5pG5tSiIbrLM7PwbJva8oVVgEYkhIlxdGbxMfKp417TZx9QcAilxB7winUntP4vnXBqUBu1J+FPKm/rSMbNN+UlV0oRLAJEmsUDHt5MkWQzpZj9JL6XQdVeFBi9vcHmuwtBPzc89mwWTRtghKWEWoASWdFhvr101l0PEaTuFT+AyHgdU14debR+G3yZUw9X9zDcACdTjOJDo3dbkdN3hmOfeay7ebzZKn2ykfOypJScu3Y5aYS36251LKiwWu9MGGlvl1AjKOfeD4kn1Urf+pnvjUDOFXz2ErT59qnFo7BCRXjN2et3Yn66PNhZn8vFfp//KyHZJ6J6S17dPhjJgA1N66RNDOhAbfggZ32UJG0eAP/iLVtWayHrlcfyf7A1POAYGJB/qElqMS5DODzvjYXrwNYhiXG0Wjy1HVu6CbvoOduTUV4tXrSSZzt8uz6zkIlg+xFp4t3GPKaZATWSwBtq7tNdn8/ffY92N5E6mROkB2qoqwXtBegGuTKggoqABUf1wQuFKHQEJJ8l0LZwvrhGjWaImj71VqeqXBgDxWSQWkbybrW2yHqereLeLV8LjdEx/29O3fu+8+Q";
        // store id = 20
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**M+RGVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AFkoWiCpSBqQmdj6x9nY+seQ**SMECAA**AAMAAA**UNBIHmlQYYTKVHwJSKY3XY7yqXWPE8J9rElKHrbN8qmp8dE4unwSiY0v++oByCL8OsSXRjOFhu45iddh35wOKOtzMy6dHE8kZoKnNWhvDnQBUsRBowJTcK4bjx8NKtoqxX7T8h4Grh3YQPiBO+MCS6j2LllOxLg5vGbXPcVHQNUCWFScQpvYouTbmIgYt/8dPzz4+QOFREq1P0CZdFK8rUiCp+md0iS2KFfNf6961xIu2bDYW7EpX3XnQnQwPxe3nUwOCtrSzEKusqFhAHkE2iWPotPyn7aaCzft7Vu76NZubUfIBAH8hMyZTKM+jMdARQ+46zZb9vMucFsu3FvOqUJdVqk86IDhlXWYstlT5f1vLhVNnw5tf+TBxEtTmxlgBPGsjqbxR2on6UUH0/SDs+SXc7uz6LC0t8eVNkseXa6U9Gj1Pks/xprKd1msBv2MxlKZwBQ2fYNOFzB5RVUfK6W6+zsgltPKSpzqChlEK2vbydEvrYrGnMU2rnoEhEdbUeYd5IOd6xAspJIqptpcb7jRTR3/e2amSNDQRX99mBnicDPv9a+ILwE1RvKa52RUIFwx5uPRiUDAEyBgpYlZpN3G8n3mLdeKyYBDLgz7W8xfpzX8pShec7pdSyR5m2FFhTkCmu9TpV3ckmxb6WcwJdCPg5j3iSMaAv9Gie2pd2un2ZgD1V6gsWtGARUnnc3wB7O5Ksl4IUNKYWb6GGzJKXZqN5hF0oOcj3loPfB2D77sHMTYnimz5nEawrNSokEG";
        //store id =25
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**GQdsVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AGkICpCpmEowWdj6x9nY+seQ**SMECAA**AAMAAA**mK3Vw8j16oAot3C8ZGeJeKAaTB4rtvys4fNJGlqB0yidJryaHxmf7mFq0OQukhUErEZ4TRVLnW6z52m2aHSoGfmrDgYr1Wj1tuTqXm8zKAqZ2Sq+X29YQktmbwwHEo7AtG1WKsXS6GtIxpESLSivgR8WdFXQTwd5YCU7ZXnvKxI3KJQJ/Nzy2fagbysj73idR2FzZcoKmTGPS1FubCEIhHEcjwyRMk99J//WqK183zTUD87owAdBYQWOHvWl0Djwjj28qIVToWCr6L4o94F4L3dt8C73Z9KepJtyaZaAviDaxT6XJ7ToiCXEc47eY+f/vO3jjFdMggE9IfnBe/tppQjp6SY9+l9RP0nlRjzpZ/ia/Duw+WGiG4cjdA2xokjZlHql+sULQ+R/tciUaa/4xnDiCQ9H/lr6ZgCyY6RE4Vi5Fvtbb5ezUHU1nRHTvFkyZtaC/W+opHtElaQocP3SErGN6T3KUU0Cd9SCIQOSmtxoD824ZPiuv7L745L/2QFsLuJkU6gGT73g9lw0KBlIsZBB6q+OR47FxDMF4kaMljAL/wMumRI6eyLbOHM07xMVmVKH54UHh0uz8v6f+FmSucLRib0ovsfNbyG0tjqLmLETgJk4QKHYVRVVUH4PVZTk2OdwZKp1XSHzHDjH+vq+zAq6FPBeqyrUkRLURUiZHrBDj9RgmR6xKzFNUin7t/vCaq1YL3RQ1DpoaRfjTlF+Y8MF8R8AvLvPLb7P/kwQIqMXtlvPueUlUoh67DQuAxqP";
        //store id = 26
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**aURtVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AGloOiD5iCqQ+dj6x9nY+seQ**SMECAA**AAMAAA**mLaV74f/WQzD/mlJbJozS3BLa9jBIIyslyFs7mm07jrACQK3uj9iedT2IEv12MnC6e0PQboMYE1YHA3D9JKXsBNbSB31EBt6X9DSxuTtvDLnPcPMnyjDnthDg3BPwUHVjqq8x+kEnBQFSZjq2zyagM3HsWOem69+kUNm0wCYBbR2ZCTfrCU0684Do9OvgAoCl3pbntu6fgqLDTYl0SoxawKVwiAk/BKJz1/zijTKeVCGzcbDN6z3XTuZdUIqX+6KQaoJ41grUPgtKSboblTcrUEJfCElQ51lkT1ADbLNl28Y0ZLoLcgKD7a3pigCcFm878iMQHxS1GHtnoEiZMPInP8MLxM6N2d/C7AUEL549bts2bsRod9o180NI+eBZ9aSu7fGzgVsFSOS5j0pvBe77Q3Ns00m69PMu6rFb9QsmHGEqj1aYADPfHRftWmSM62lpTRYslquD8/TB10FtGqoGCJVMJdxT2cBV7zxoaaviNRa3I/t8eKCteOL+HsL//gutuDunRDOrqspfj94W9iOX/PczkrV59rb3e8hUSP3Eg1fZlx2yIbW+q0PtO8r89xS2N59B+LIL6cVARX8fPc2IvVv4sXjRGrRTtrIM+7kteD5aQ7I2zwzD01bu91pQzyCeyBHmFh28QvxLauWc8xVblGe2FoaPl0uPMEKD0O0vMpVF4DYlGZbkllBK/AjzlfN5+KiU2Wr3g3a6gLzz1jnLKJ1KRt0iGIvRgyA+LvDd/e/1jM1pKpb8cxt7eFXTlwx";
        //store id = 27
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**8MqCVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wDloqjAJGLqQidj6x9nY+seQ**LMECAA**AAMAAA**mpMjmvc/44HV2rNWohhAwkCIiDOFtDRlA4UoZA1r0VLqjwMfkO1gG8+jN2Hw1jWHjOrc5HFyDbdM391i3C1SaFecghtyVb8/KiNMATVH1wu/FMwAJlWI+EAH19slKfaOXx0jH9Qi6iS7xTD++5uekwON0ghbUy6utVBZT2NegawfD2npqu3UoxhUr+uMU/HSFr18sKyAhjix/G/ZovyYYVzjII4rilKSxTowoP/FYSHDn6DC2mAEpH1TA9FEuHoInIYMnHeUxE+jbgleZAwvMqQDEOwF6620q4KgovW1q6jgJrdcrIrP+rasKVSl6rL1nJWlzZz2TetrdtQfyHibh4IM57gWFK9H8+hqLW0m+HJFJ5FeGj0AYTF/EFs8CS2XSpm4uHaxCOwnMp7rpG2YWKiOPZWkHTsE6COeMJU81E/AIO7kT0B3YtPDppcWqZ2fiYsMlmZslp2nyHxBxFBda72Z8qcy4rQpV/KG4+vHJds4DtSs7AY1UEw8EN+TNezkkJL4XR+BqNHhSSulVBeGEgbK+YDNw/wtgBMG17+0y69j07bE5hFxUcgz7Uw5ZHAKVA+rpl2uUyva7GitF0YovcsTz127rPnB6Noz+1a7a3kRt+h79br/gB2LiUiTvtQQIOnfpOL+X4gJxvLrjW17qpqcqjcWkkvMaQnsIPMBU2XYYoquHYwH4aeV4M3km8bWBcdoDbgK4I2C8Izo9r0+7+whBqK3kMD+kX+SCpLxivGFtQaJSGP9/PPS8vyEKUEA";
        //store id = 28
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**hvOIVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wHkIOoDpeCpwqdj6x9nY+seQ**LMECAA**AAMAAA**z+hc8/jPa5MGSCcEYWryHuAGGnlDutfExCxt53ADNGlYNMYG4ybQOZXT5COw9sa0VjZZoY3oELMtMOhwPkUW2uBy42Sft4aDTnhuK8zJycLKcp521iIDTSR7Zug7irDHGCiAc+idEj+PQqmyZy0YXjjQ0sdjwoFoTT/2Az870utY2wv4wBqottAOHsedrXxYgZ2Y93GTb19JWcmpBcf3NLTbrxu99Sq31h1zhDmhwc1nry91Y4SsawpN4BPudCxRQHBLNVRpvY7sM18cOYwNjxjxfKVuuHJMVpnHZFNV3GyDvvnNHaCDL6s3NIUxF93hiDlUUR3qPJzV9M+MXEOsECVjQSR7tbQi1MByx7ssFRcHIhTjzaEG3FgA5i9E8FA84jhYFM3/AkJY9mBjyIsdGB8kxQKS+Ilj5xx5kwoQZGQw30d2Z7UXMXKpvuZ1dFRLUTU+7U2HjALOMiAyG9G8e3g7yjoNU2t6FVhfF3w+gunQYKmyGj3CS6lyCdSEQiYEYza4M7LnSePM9tEaHelfN2InOCBl08+rIjyMuJ7hqDPWjiXfW6KRm7xOo/q6y7Jlt3FsqMbARr778CdrcK+n0Z3oDsw92AKYQKpujaVwd0Zvj5uhNrQjxsb86tFFk7IHq1tDdA5CL/iEh84djQ54DXxiRet3OEMZx9A0zmOAEWVokH6CCPpYUkTO2kIDs42SgOhbtPzdtg1Tmu8J6kzrKvawvyP4eYZgQ7FFsuAppTguwRBIfM4dzIBIRtS4Hqz0";
        //store id = 29
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**hPSIVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEmIGiD5mKowmdj6x9nY+seQ**LMECAA**AAMAAA**TO3xoqA32roHjrkZJTkTnOXJvl7e1YBWyKOR3DooY6+/rE7KBPGlcU6oo6YUc2hUvU3tR45m0HRwKY/n1V36sZ+e3d7ENLfFisUDusekfWFCfvDzhY7riLKMbwye5tVs+dz1ZZLfoMD+aWyVvoUiZa6cSqDI20BaUK+EH69ZWJa7M8Nn4epjeJv6npmoAHa4zaGqrGgz/8sQBNZ6V5+CzNiF3HA1zU10Xjh13+QdjLhaaRPYE2tF2gccqGflikNfBHyBRN/l3EHES1qhnK2DfIEVrW+kpMy2U6hyz3t4Yrn/Zuze6SZXueMXJg1a7xQngGvf6a4N6RZi7FSRbDpLprzBv+u/7YaCbpTShk46Sx0fw3zIHpIDJblv0I1PVOZodrQJYnCZbgWzIQ9ZTVPtwu4co49eIEZggdMoVe1aH50tH6iiJN9MehOtBB070+5/i718so9dRLPrdYYIcgYFcI6AbHQtTfuwHLr/JM1QQAb2yGOfHXI3AhSNtOuemUHshJtyfZ1ROEr7gl9VHTinAjVNRHMCMF3N6+ktv+8iA2yfl7w7+m9ZV1psSYvka3g542o3JK1jw7PblEdKp8/rWJn91LQ9tf8eJC7ILbrMUdFxMKdfrisdVygWI6gEWY9W4sV5fphDmGQv6dG/77/bmW98d8HFyB1R3TABUO7Xc6MwBr3L5brTyEJk/FGDjeOgmAHqd5f/4p7iH/VJsVJq/Q4oDiz0rty8TygBUc8HdwA60zCWqA2MyHtPOjsw/B7K";
        //store id = 30
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**KPWIVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFlYCgDpODowqdj6x9nY+seQ**LMECAA**AAMAAA**2EFufZVM9e7gyj4g4/IjAy26PQ/4HopfMmU2OFWn2ggmgbZVT578J3GJ62s9JJC8jkkVYZ53MiBFqO+ExZhqQcOxNSUMy0tWx9SFHZ5GE4wjZTyBrV1DM+T9FCnu3RL038G7UxuCLyU6lwltTSVU4sdV2wh9nFsb3U+RPRagaHKiAD11DPkjbX9zB3ddK+SugbDsAs5IgmQQN0gV0sX7d+EbDt5uEfaMjAYYelBinZPq7Ltu1RTv3JQSCFwjoV0i3ijABUp2+SN2i4KZFXHYW6QDLLEfczDhlqY+aa8NEagEE61J05zElKuenIyTNLAnbDFgb93tmgnRDnss7PTrg9mPt9nlWYtDKlfN+X1DSC1E19tcxXtQ4DyWxIh8SN+d9rUdohc1mmJxCkgzcp6OKZBfoy4Nu40PoGi9gT11JYHESt0ABN37H7mYDr5BQf8Ygdaa67SnjrOdNQHCv4Se4Rva4I7gTYOvbbLBp/aCE5UySez55C3WgQKOQF1B6GlfzV86qJ3DmNB4v/7t/dnhuPvoJuFlIg+RSzafCBHlmKf8hmcmABr64e9Bzqj2Ncf3bXZLgqSj5XkBFuFEloSCh20XaiFtNpCgiYJ9p7pXT4+EWFYPBJJ/Pvkvzv3FWxUDS7BQb9xxgJzwybzpaPkFCPMXwSceobYbHC7aQv8xY9C4pG3btvFeM5xIDciUG2MeBjthP04y1Dp4fB/GwDi3b0lPFfokGKNl7yaDcnl/ugfE28nIF7K8HCI5OSuzekdC";
        //store id = 31
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**d/WIVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFlYOmCZWGpA+dj6x9nY+seQ**LMECAA**AAMAAA**W8qyaYkZFCRZscgjwsC2aWMdrX0qe86NslGnB/9xVLn6nROMXu5rZjgKF0A4KKwDZqNkqiVDPYwinjsTg1jlaCF9qmpXK+uGUMKso0PQzfz/moAEtOb7GKo86itG0gzj+D1vvX5ABlFixfiG7nm5Txe8eyh+l2uTsx8tO8sXLEIjdf8BbX1qSzaxKT1WIaQdFcz6C0QAkxjIq1N/wGjCmBQn1YxqwUlz5BSGYou6ITYNIDJkBEh2YVvjOdALDNXO3ihKm+UEA9PghZPCNXRbFmChcc5rPKnncc5wir3s5lQGUbVRjTKWz9V5mjGVwg3XbyfVqQlOjYKVU8KHC+zrRoGs7ud5tNmCse75nWKEOTGzHRDPT+l8MAPUhEnCyzgMPAtNklvNsePdwCuEFTZbqo+WHmtQ2tA5GPgu0apsai78ai9QquvIbIQfnSIDlXFM6frClVEwvf+arISyVN0FxepGeaXYTNhT2xjQemp8qun+ymy++pJQ1hCPNG0kP5msEBjdvaEJZnC3nY9OMPJ3geRanNqEaF6gDkktbM7Lhdwfrpis5zv3D1XxiIMEo+hgvMesSV/h+9D5DfoMKP9kY7u9mvOykj+yWGRySsAUwDFLpSoPDAs4UEZ7N8Fq/LiKC211HI7gKhSi8Q13zZ737C5HyGsHAh2MFt2r2XXJxYgteiokNK/pFG4pQj9iQ5HtH40Up4wOL3+4Zg2Jwt9CL71wxndPMpxnlNT9Xf0uJ4EP9LNY1hft/vpN761afisf";
        //store id = 32
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**zfWIVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEmIGjDZKHowqdj6x9nY+seQ**ScECAA**AAMAAA**1hvX2v8YL8NNGgPk8d19Ku4y9U60DL+j+l4AEZO/SJYm9QdCORN5tqePMLX8M/BBhCnHju7qz9QdzYFQXSsddzMixRl4Hq1eWq8fWUb99mJWlKa3LKM/GzkxYUu53jDV1v9AZfXh4ZE+Qs1nJP4/aoC4CBziYASFiT1ic/JIgldXW8CYN21FISOsY2prt4EL6AsNujANnYjH6Jwa9Mi3NeyULt9QiWHwCsN1u0Fz1MjAwTMuKRtFf7U8nNN5AOFWKdMnyuzVfwMN1FTCDRk+u4PkMCVVnMFdUgt1dACw++o6tXFokGW/0SBFy40bj5sf3baxP80Mh/R/gT2LKuxZHLNsql+39OJxk73yBmUV9SFwn2peFiW94lmgyVkaz5IRKjWnea2v3UHCTDqScl78b61ojPCWoJvERApc4VAtKWmRPt7s7kfF/Oy9RXfy+BZT22kr32evu5Yy4iPVUKz4fad5Lwp3hf9uzbM7qkcFUc/7QiupqBMEXYp9SY1ktGrcK4LedoA30JbBBC7xYjMZDkCmc5laVRiKBiiuR4tDfE3tkTczibW0KF5OIqVl6LRyZygcHPWHmY0QRMdlvO2qrv5FkLJ4G8EbhpCp8LiBfnVCdpTGmw4cD8ADA4iedivdQo6xlbiiMMdRRon6jLAUa8Pwm6Ac/2Rz31I80odcnekuAX/Co2xo5vPcN4t+K+AsEofxEjSKlzr7gi2OnpT/MHBI4ZoQ7qgaUPBplpH0yyfyh9Wse89xfnNbzUXd00Kr";
        //store id =33
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**FPaIVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFmYWlCpKDoA+dj6x9nY+seQ**ScECAA**AAMAAA**jIkGvya6nk+zn1gsoWaUNFQUiReSJAx/IdGh8qoQGFzDF5HG+CFL6x6V506fKH/KH13dnFcoQFJsZZy1lYIFOXrmKOWaVwMa58oFutfTEQHS7KsDYRAVHi1lGjpDDU5CIpfMTWd3P0zyFfyTw8MNu8LsMKXRtSXFY+lJR9DFrebhTNSiQCC6+QDSTYDbsJc7k8PI+fQciNR6dSYlSr96Pmq9vYo2Ogwy8LfXKRyyUSodTu09uIDfJrnEktop5Ggt+GWldcJZU6VgzI7pUWQpBQwnHyCAuKHuc+l1GSfYRwRt5HSFsdjVZcqtZaMxuodPtgloR0uzpaK2I9vVQBBUPkyDfpxRxOWX2DoLjwvTPdlp0AEr5ONQjTXaYtdsUpE4bDc9iCnVnoRXEENR2DzJDWQU/L1RztC8iAzzj8fdg0px44GaEXJaULGqVA4exRi3l+TDGpiJvdwE5AYUJyMvb3uRpL73qP6Z2179T7Np943yVun8+fqkm2dI9L9RH00rgD8faFqV5f9tvWj/xhJNNli2ubbpO13FF95BTKECYTN9OpKeVuOM/VVlstVw/kWGUFi7XPvb/H2S8UHBTyO2BbGTRPVQDiQr0+uRDJ9Ka3+eO4Fp2VJpTxVPZ5SRll+3UJkj426ccq04iftZIpT4cwJWSAxtecwefon9FF5X+y+7IX3amPTlNwYfqw6HjhCD1fy5t4q91HSn8WMBk3WmgxGI6b3YT3aD1o0LhcLmH+NzkXO45ufddRwqycZ3gZb7";
        //store id = 34
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**JfeIVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEmIGiD5iCpQqdj6x9nY+seQ**ScECAA**AAMAAA**QjYOgGxKpcexRsaL1Sk6nb9uonwi3801tiTbW9HwgaYVbBW7AZ1Vse0ko6UXC3rSnUB+grTd+hGSpieGExkjW5xnKi8Gsq+ACLyBSHhr0wDF1DkxqBL9OwQ4ZuDWlg/FQVb00Terrmf2MPYZ2xqwFsPXfg1meD4yRk410LwiY+SDCvVdirZwQS6hLKQ00FSFejrlLsZC7COCusxrJk5s/gq9A1ZNFYeTrcf1o6ZjToe16+UtZTlLmGZe5O0M90xE7yFxfmiaNKxPPNuIrm6DQr81oL+gAPsXUeh5sBP82plzu/BxiO6/XCrvMtTHJDDE0n3mSdddXwGb3Wz2/hchRZo8dofCGUogrqesMbr9oeouXJmJrqBwEKveG5n+Ia/P11sWvLvlaczDdyVuaBsDRtZYSTUv7v9rqeEcHHLBd+G63Z1L24IyBS8wqoD+IJzJqsZvy8SbYsSbYLivDKK1vQb1qkt0c+nA/9zC2hckeFhFJHXN9dhJxdrhduxJiCpTa0fhkA4ZwXXb1GjPF1ePLxmVcTQT8U6hpL0hGRR3Z2kzAeHjvd38SMTHtiiDbtN8eZw7n+n6LQwcTcznDIWA4kBHWAcYAsBuL/HwpB92aWPcBYEn0rsSB2IEboMU9w3pYTPFheQx9lj29HlRPukQpVD9v+I4kGx0Slp0iaVqJrUnzIyjzUWfcggoVYi7i8YIYYBESEe94rWbeZ2NkPwSsGGeNFPJXcbukI3h2xELHfOKrTGHPPacf2eT7AwwAtY8";
        //store id = 35
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**ncCMVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AGlYqiDZCGpwudj6x9nY+seQ**ScECAA**AAMAAA**xYJdfQWy24T5VE/B3h5+y382ZTV2erGGFT1BTtL9TCfApVlWn/mgxPuqN+/MQPCWUW6QCtOrcAOIN7MEGypRe+8QihAEDGs19rB/XzAOM17AD3N7uLUa549IhAH4iSUe83b4AaH4Zk/yxUSEvqc9UtQOMmJk9iDW5RIl1APdQ0lzuT2wDfPpzfkWQLRvTLA788E6UPlGKC16NCgV8I4PUeOjlg4mWpxAJQChyGiuKG9VjdoPGRBllX382CXM6wBbF5TwLembfgFKbf+W+niJUy9UaRds9z+M9NyIWoY9lUrNVKwn5ZQva0gHpKg+TV4S/GQ9F6+3lS7ZGcK+92XIZtYZGdKMJTbf/go3QAGTdjh9qf/Y2+9qWyc2B0vvOELSvLYfTTABRmKGvLlJ8E5084aKQmCDvvma3hvdMV1FcH+Y1YQPY4Ys3/nhldscUnm34qfinJuUaIe3ZXBnbEIkWDujqQMNRazt1gqZ/Qm+FMoXlKoS8982KfjbpuQQBQ6ofKXuPOX/K+VaCajgruy8XJ1U+VK6Vz7KNYswY9+QsGJAgpSYofOrIvsWoYGgb2dFfa5ABlJcYQCi1ffs33B5Wb81SMD2pTL3eQqo3HVGoXi/mTO8D9boOKC2iR38mdkZ/d+7QPk1s+F6sEWaYQM/8UM+XQgCRqSZyTX/pY9ajYNso4ip0c+4cDiqbVtZjp0kNQZs2EnJKiooIozTUhmbGxS/btlRHpKsEdikIywYy/Zxe4YYR2qd1qboQuIjoxRM";
        //store id = 36
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**xr6MVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AHkIClDZiBogSdj6x9nY+seQ**ScECAA**AAMAAA**8B9AGAZ7jHfLhlzZDqmkKrLcOnr9Hz7siTQX6tzrVIhgHnpmotHDRiLed2Tqi/HM7Yc2N/+lKBPXaFbVWtidT2BoXNJ7cILqdcRm3hz8UlC6fUcl6q+2gOjc0NvN4cBWXHlY9UVv6zPDdXCxXDodFCBDVZLN4qKmxcaA3eP1vKAHunyCm13u1f67N4G0jRUHz/MVvsH83ZD268scfh5tO9xjNtlwQj8WQ2I2YzEuS0Kw6i/WahHDvLj9RJV4YmHfEvtyC7sSSYJShmsc2RyGD/A3G2d0aJqA0ybLrWOSV4N7oMiHFB3jSVcbAPUsLEFdaGim0wzV+VKZoH0alzzoONjkmfEl+5/ZbYIyzjthJ0wTOYnAygELCzJYEavgs3gIIvD+nA2Zcqwg8WQ8N9X8Q1XiJHJS4Vo4dH66ohnxpkhgnKmR791BaDinJvl14dpAcfsZKpB8fTJ+qC0+iCz/I21j8BkHJ9d24fj0ByGyuWgnt87o7LYh1QvMO8cjPmathOt5tDL1sCzSCKvAXdipdl1HeZSsCUpxz+P8lexSXE96Pfit32V8jy81L78Ju2lhpFGwtnU3n5Wgqdr58WiJA2f4CEefXY7HQvjqJ3BR+8kamh94QCBgdCyzoKx3H06iavwrlcuYJz4p4EaPdYbh7uD4Y/JKcEU52HbYzXDTSnX9Zpb/GANoqCSME8lzG1+9t8OJ2mPzsz0XyRrWZlEeFZ/CblVfKzySVFFVzeKGbZACn2QQfG4Y3qPrXwo7asV9";
        //store id = 67
        //String userToken = "AgAAAA**AQAAAA**aAAAAA**7QumVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AFkoGhDJeHpwmdj6x9nY+seQ**JsECAA**AAMAAA**MZRawn2GyMIFEZw8Jbs0duplBLRfHVCyQLZIIJS5Lq+t2sVzecsQKTddDH9GQDhFAZoQ1BgQCAKiRgVdeXw+xBUcEQzofrwrrwrgkDPIlgjnzrEUu8lyyFRAJGe05Odf7zZDP5ji2EMr0vIukPkqQQwAZjMwzUTjxovFwZ+aCA12sJaQ3e88j/PzLiAsdGq37fkd2x7hIHCsKldttNkBiU5v/Q1jPgyazsdW636uOh/3RFk/bHJYCpeW0pQlNRqbfyISsH9BGYcX+Ft+iRQhj1qwxiVJoWErVVPYr6c3b8VRhRl4Uid/NRRK1Foo7Q8YW25MhEJlvUcMNVad1Mgd2XAtdAivBFpkUt5csYpZfgo728SbbzgMB/e4G/PbphTIvG5qqja67JF7baEXAG8ryZrARfUg6atPiThNa87hMKOtZcnqVheGLzLeERjVNW/N7D4/fHS7d85kNdvt/tFRrFPmuz9G/kh2ItZlYPAd8ZiecbP0gW4czc2DSceopt3wF/kz47M5GaMIvzTbqjgU8NPfxxTqWvnNfiMkOcMc/O+louU266TCT5M3bb+/yOh2ORJJ89+d6alsFSMesmbS2I6mhL4FF1/9Ch419NKi2jlpNvYXPX9caRHX/hbw1U36Hw4rQly0xc/gqRCFdEElBk/j4DVJpqGAhknWgeOwCBMtKE/+8EP17aarP40DpAVbnvtLjto4mbyCNVKsAaPC+AO7kqPcSLr/KzIrIxiymdqe7uEog7ImGGCBLVhaE7NV";
        //store id = 68
        String userToken = "AgAAAA**AQAAAA**aAAAAA**gAymVQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AFkoGhDJmBpA2dj6x9nY+seQ**JsECAA**AAMAAA**yGoineeSwMMPxfALnlPeMe+4Sz8hfbfQDdn/6gQh1xNEozU7zXB+PG6VnX3s0I8dVg9hVuKh/at1XFf4WcdPMXa21wYUtJC/RgzhIFHAE+tXg9a0qauVPmbNJhYnPJuKpWOupDsFiqqV3j4ChChKr8vvUZl/DW2uPC7qW2Sj09S6RWCNl19JyS7nYS0QqRwhc7koXsTJbfPk/7Wvp3pHbvR9DWyJWi9gV0ZQEFh7Ki95xsGrS5l4em0svAWhTfAuhMFhRQRBfeMoPsJ9XDfdpnxYwqGUzoFxuS3+3I+eZaxh2NCAkJR5lkcYA6PK592nk5o9kdpHgbulnRylW7OcAxrHVWtBktWls3qIhSu0NFPwKsNRrQ4uK+px2nAwIVViOWWvzQxockOrLaBM335U6eqo5STwVEtoLyDMjFB1t2eK7a3MaGlAZsvCnJ2m3wFvkNWPyJp5o78kdWF8Y99qF7bajlvYzzeoEFi9nHANLYQJ3ihDu32ufGiroK76otU9MoWQN0uq+KgFjIsn77iWAApNexpy8jJfaUh6BbWpq2aLQSS1EnOovEffTaqxP6LJPaE2LB3Nbo9saMbJFu51nClLPEdlsqgQLIEbgfhZEZ7fIVQZ5UKYqse1zVnRpQ/fskJlHNIBZsYpBfdQuQBQAQ1i6mUUE96/tvx6OxOKIRtO2pxI51FN5usO/VHRKLN3fblYLfQxrE11s1keh45nZ4+AceSCx7X/W3UpzDWL2B0bN+oa+RGpGEIMqqpGubU1";
        executeCmd(args, actionCode, userToken);
    }

    private static void executeCmd(String args[], int actionCode, String userToken) throws Exception {
        String uploadFileName = "", downloadFileName = "";
        String jobId = "", fileRefId = "", uploadXML = "", jobType = "";

        switch (actionCode) {
            case 0:
                 {//"UploadJobEnd2End"
                    uploadFileName = args[1];
                    downloadFileName = args[2];
                    logger.info("************************************" + uploadFileName + "开始调用********************");
                    long startTime = System.currentTimeMillis();
                    logger.info("\n******\nIn LMSSample.main() ===> UploadJobEnd2End Job: uploadFileName=" + uploadFileName + " ;;; downloadFileName" + downloadFileName);
                    if (LMSClientJobs.end2EndUploadJob(uploadFileName, downloadFileName,userToken)) {
                        logger.info("\n******\nUploadJobEnd2End finished successfully.");
                        long endTime = System.currentTimeMillis();
        				
        				logger.info("************************************" + uploadFileName + "成功结束调用，花费时间" + (endTime - startTime)/1000 +"秒********************");
                    } else {
                        logger.info("UploadJobEnd2End failed.");
                    }
                }
                break;
            case 1:
                 {// "UploadFile"
                    jobId = args[1];
                    fileRefId = args[2];
                    uploadXML = args[3];
                    LMSClientJobs.uploadJob(jobId, fileRefId, uploadXML, userToken);
                }
                break;
            case 2:  //"DownloadFile"
                 {
                    jobId = args[1];
                    fileRefId = args[2];
                    downloadFileName = args[3];
                    LMSClientJobs.downloadJob(jobId, fileRefId, downloadFileName, userToken);
                }
                break;
            case 3:
                 { //"getJobs"

                    String conditionsString = null;
                    if (args.length == 2) {
                        conditionsString = args[1];
                        System.out.println("conditionsString : " + conditionsString);
                    }
                    LMSClientJobs.getJobs(conditionsString, userToken);
                }
                break;
            case 4:
                 {//"createUploadJob"
                    jobId = args[1];
                    LMSClientJobs.abortJob(jobId, userToken);
                }
                break;
            case 5:
                 {//"creatUploadJob"

                    jobType = args[1];
                    LMSClientJobs.createUploadJob(jobType, userToken);
                }
                break;
            case 6:
                 {//"startUploadJob"

                    jobId = args[1];
                    LMSClientJobs.startUploadJob(jobId, userToken);
                }
                break;
            case 7:
                 {//"getJobStatus"
                    jobId = args[1];
                    LMSClientJobs.getJobStatus(jobId, userToken);
                }

                break;
            case 8:
                 { //"startDownloadJob"
                    String startTimeString = null;
                    jobType = args[1];
                    if (args.length == 3) {
                        startTimeString = args[2];
                    }
                    LMSClientJobs.startDownloadJob(jobType, startTimeString, userToken);
                }
                break;
            case 9:
                 { //"end2EndDownloadJob"

                    if (args.length == 3) {
                        jobType = args[1];
                        downloadFileName = args[2];
                    }
                    LMSClientJobs.end2EndDownloadJob(jobType, downloadFileName, userToken);
                }
                break;

            default:
                 {
                    // print out the description of available commands
                    System.out.println(printUsage());
                }
                break;
        }
    } // ENDOF executeCmd()

    private static String printUsage() {
        StringBuilder sb = new StringBuilder("");
        //int actionCommand = 0;
        sb.append("LMSSample sample commands\n");
        sb.append("=========================\n");
        sb.append("#1: java -jar LMSSample.jar UploadJobEnd2End D:/ReviseFixedPriceItem.xml D:/download1.zip\n");
        sb.append("-------------------\n");
        sb.append("Input parameters\n");
        sb.append("1.Action String (UploadJobEnd2End)\n");
        sb.append("2.Location of XML file to upload (D:/ReviseFixedPriceItem.xml)\n");
        sb.append("3.File name for the download attachment (D:/download1.zip)\n");
        sb.append("\n");
        sb.append("This command does the following steps:\n");
        sb.append("1.Get the JobType from the input XML file\n");
        sb.append("2.Compress the input XML file into gzip file\n");
        sb.append("3.Call BDX createUploadloadJob service to create a job\n");
        sb.append("4.Call FTS uploadFile service to upload the gzip file that was created in Step #2\n");
        sb.append("5.Call BDX startUploadJob service to start the job that was created in Step #3\n");
        sb.append("6.Call BDX getJobStatus service to see if the Job is completed\n");
        sb.append("7.If the JobStatus returned is not yet Completed,  then sleep for 10 seconds (configurable in lt_ebay_lms.properties) and repeat Step #5. When the JobStatus returns Completed, move to Step #7 \n");
        sb.append("8.Call FTS downloadFile service to download the result file that is specified by the 3rd input parameter\n");
        sb.append("\n");
        sb.append("\n");
        sb.append("#2: java -jar LMSSample.jar UploadFile 5000000636 50000000236 D:/ReviseFixedPriceItem.xml \n");
        sb.append("-------------------\n");
        sb.append("Input parameters:\n");
        sb.append("1.Action String (UploadFile)\n");
        sb.append("2.TaskRefId (This is returned in the createUploadloadJob service call)\n");
        sb.append("3.FileRefId (This is returned in the createUploadloadJob service call)\n");
        sb.append("4.Full file name of the XML file\n");
        sb.append("5.useSOAP or useHTTP to indicate which protocol the invocation will use\n");
        sb.append("This command does the following steps:\n");
        sb.append("1.Compress the input XML file into gzip file\n");
        sb.append("2.Call FTS uploadFile service to upload file where JobID is the 2nd parameter and FileReferenceID is the 3rd parameter \n");
        sb.append("\n");
        sb.append("\n");
        sb.append("#3: java -jar LMSSample.jar DownloadFile 5000000636 50000000236 D:/downloadResult.zip \n");
        sb.append("\n");
        sb.append("Input parameters:\n");
        sb.append("1.Action String (DownloadFile)\n");
        sb.append("2.TaskRefId (This is returned in the createUploadloadJob service call)\n");
        sb.append("3.FileRefId (This is returned in the createUploadloadJob service call)\n");
        sb.append("4.Full file name of the file it will save locally\n");
        sb.append("5.useSOAP or useHTTP to indicate which protocol the invocation will use\n");
        sb.append("This command does the following steps:\n");
        sb.append("1.Call FTS downloadFile to download file for the job where JobID is the 2nd parameter and FileReferenceID is the 3rd parameter \n");
        sb.append("\n");
        sb.append("\n");
        sb.append("#4: java -jar LMSSample.jar getJobs creationTimeFrom=2008-09-01&creationTimeTo=2008-10-02&jobType=RelistFixedPriceItem&jobStatus=Failed\n");
        sb.append("\n");
        sb.append("Input parameters:\n");
        sb.append("1.Action String (getJobs)\n");
        sb.append("2.query criteria string\n");
        sb.append("This command calls BDX getJobs service to get job profiles that satisfy the query criteria.\n");
        sb.append("\n");
        sb.append("\n");
        sb.append("#5: java -jar LMSSample.jar abortJob 5000000636\n");
        sb.append("\n");
        sb.append("Input parameters:\n");
        sb.append("1.Action String (abortJob)\n");
        sb.append("2.JobID\n");
        sb.append("This command calls BDX abortJob service to abort an unterminated job where JobID is the 2nd parameter.\n");
        sb.append("\n");
        sb.append("\n");
        sb.append("#6: java -jar LMSSample.jar createUploadJob ReviseFixedPriceItem\n");
        sb.append("\n");
        sb.append("Input parameters:\n");
        sb.append("1.Action String (createUploadJob)\n");
        sb.append("2.JobType\n");
        sb.append("This command calls BDX createUploadJob service to create an upload job with the given JobType (e.g. ReviseFixedPriceItem).\n");
        sb.append("\n");
        sb.append("\n");
        sb.append("#7: java -jar LMSSample.jar startUploadJob 5000000636\n");
        sb.append("\n");
        sb.append("Input parameters:\n");
        sb.append("1.Action String (startUploadJob)\n");
        sb.append("2.JobID\n");
        sb.append("This command calls BDX startUploadJob service to start the created upload job where JobID is the 2nd parameter.\n");
        sb.append("\n");
        sb.append("\n");
        sb.append("#8: java -jar LMSSample.jar getJobStatus 5000000636\n");
        sb.append("\n");
        sb.append("Input parameters:\n");
        sb.append("1.Action String (getJobStatus)\n");
        sb.append("2.JobID\n");
        sb.append("This command calls BDX getJobStatus service to query the job status where JobID is the 2nd parameter.\n");
        sb.append("\n");
        sb.append("\n");
        sb.append("#9: a> java -jar LMSSample.jar startDownloadJob SoldReport\n");
        sb.append("    b> java -jar LMSSample.jar startDownloadJob SoldReport 2008-10-10_12:0:0\n");
        sb.append("\n");
        sb.append("Input parameters:\n");
        sb.append("1.Action String (startDownloadJob)\n");
        sb.append("2.JobType (ActiveInventoryReport, SoldReport, or FeeSettlementReport)\n");
        sb.append("3.startTime (Optional) format = \"yyyy-mm-dd_hh:mm:ss\"\n");
        sb.append("This command calls BDX startDownloadJob service to start the download job, it returns a JobID.\n");
        sb.append("\n");
        sb.append("\n");
        sb.append("#10: java -jar LMSSample.jar DownloadJobEnd2End SoldReport downloadResult.zip \n");
        sb.append("-------------------\n");
        sb.append("Input parameters\n");
        sb.append("1.Action String (DownloadJobEnd2End)\n");
        sb.append("2.File name for the download attachment (C:/download2.zip)\n");
        sb.append("This command does the following steps:\n");
        sb.append("1.Call BDX startDownloadJob to start processing the data for a report file to download\n");
        sb.append("2.Call BDX getJobStatus service to see if the Job is completed\n");
        sb.append("3.If the JobStatus returned is not yet Completed,  then sleep for 10 seconds (configurable in lt_ebay_lms.properties) and repeat Step #2. When the JobStatus returns Completed, move to Step #3 \n");
        sb.append("4.Call FTS downloadFile service to download the result file that is specified by the 2nd input parameter\n");
        sb.append("\n");

        return sb.toString();
    }
}
