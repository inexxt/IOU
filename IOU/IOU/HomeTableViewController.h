//
//  HomeTableViewController.h
//  IOU
//
//  Created by Bandi Enkh-Amgalan on 3/1/15.
//  Copyright (c) 2015 a. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface HomeTableViewController : UITableViewController <UITableViewDelegate>
{
    IBOutlet UILabel *oweAmount;
    IBOutlet UILabel *lentLabel;
    IBOutlet UILabel *oweLabel;
    IBOutlet UILabel *lentAmount;
    IBOutlet UIBarButtonItem *newButton;
    NSString *accessToken;
    NSArray *transactions;
    NSDictionary *profile;
}

@property IBOutlet UILabel *lentAmount;
@property IBOutlet UILabel *lentLabel;
@property IBOutlet UILabel *oweAmount;
@property IBOutlet UILabel *oweLabel;
@property NSArray* transactions;
@property NSDictionary* profile;
@property NSString* accessToken;

@end
